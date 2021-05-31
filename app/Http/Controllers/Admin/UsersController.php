<?php

namespace App\Http\Controllers\Admin;

use App\Events\AdminLogEvent;
use App\Events\BlackTokenLogEvent;
use App\Events\GreenTokenLogEvent;
use App\Events\UserAccessEvent;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\BlacklistUsersRequest;
use App\Http\Requests\Admin\Users\UpdateUsersRequest;
use App\Mail\AdminLogMail;
use App\Models\AdminLog;
use App\Models\BlacklistLog;
use App\Models\BlackTokenLog;
use App\Models\GreenTokenLog;
use App\Models\LogDownloads;
use App\Models\MessageBadge;
use App\Models\User;
use App\Repositories\AdminLogRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

// use DB;

class UsersController extends Controller
{
    /**
     * Fetch a chunk of all users
     *
     * @param Request $request
     * @param UserRepository $userRepo
     * @return ApiResponse
     */
    public function index(Request $request, UserRepository $userRepo)
    {
        if ($request->filled('search')) {
            $query = $userRepo->search('name', $request->input('search'));
        } else {
            $query = $userRepo;
        }
        if ($request->has('download')) {
            $request->request->add(['paginate' => 0]);
        }

        $users = $userRepo->pager($query);
        if ($users instanceof ApiException) {
            return ApiResponse::exception($users);
        }
        if ($request->has('download')) {
            ini_set('max_execution_time', 1800);
            /*
            $xlsx = $this->createSpreadsheet($users);
            event(new AdminLogEvent($request->user()->id, AdminLog::TYPE_ADMIN_DOWNLOAD_X_RECORD, [
                'admin' => $request->user()->name,
                'type' => "User Access",
            ]));
            */
            ob_end_clean();
            ignore_user_abort(true); // just to be safe
            ob_start();
            $result['success'] = true;
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            ob_end_clean();
            header('Content-Type: application/json');
            header("Connection: close");
            ignore_user_abort(true); // just to be safe
            ob_start();
            echo json_encode(['success' => true]);
            $size = ob_get_length();
            header("Content-Length: $size");
            ob_end_flush(); // Strange behaviour, will not work
            flush();        // Unless both are called !

            if ($request->filled('search')) {
                $query = $userRepo->search('name', $request->input('search'));
            } else {
                $query = $userRepo;
            }
            $request->request->add(['paginate' => 0]);
            $dateGenerated = date("Y-m-d-H-i-s");
            $filename = "data_export_" . $dateGenerated . ".csv";
            $logDownload = new LogDownloads();
            $logDownload->filename = $filename;
            $logDownload->status = 'generating';
            $logDownload->type = 'User Access';
            $logDownload->save();
            $now = gmdate("D, d M Y H:i:s");
            $savePath = storage_path("app/reports/$filename");
            $df = fopen($savePath, 'w');
            fputcsv($df, [
                'NAME',
                'DEPARTMENT',
                'DESIGNATION',
                'COUNTRY',
                'CAREER LEVEL',
                'PORTAL ACCESS',
                'ADMIN ACCESS',
            ]);
            $request->merge(['paginate' => 1]);
            $rpp = 2000;
            $request->merge(['rpp' => 1]);
            $result = $userRepo->pager($query);
            $total = $result->total();
            $perPage = $rpp;
            $request->merge(['rpp' => 2000]);
            $userCache = [];
            for ($page = 0; $page <= $total; $page = $page + $perPage) {
                $pageVal = intval($total / ($page + $perPage)) + 1;
                $request->merge(['page' => $pageVal]);
                $result = $userRepo->pager($query);
                foreach ($result as $key => $data) {
                    $row = [
                        $data->name,
                        $data->department_name,
                        $data->position_name,
                        $this->countryCodeToCountry($data->country),
                        $data->career_level,
                        $data->is_active,
                        $data->is_admin,
                    ];
                    fputcsv($df, $row);
                }
            }
            fclose($df);
            $logDownload->status = 'ready';
            $logDownload->save();
            $user = $request->user();
            $message = 'User Access report generated at ' . $logDownload->created_at . ' is ready.';
            $subject = 'User Access Report Generation Process Complete';
            $isPreview = false;
            $admin = $request->user();
            $user = $request->user();
            Mail::to($admin->email)->send(
                new AdminLogMail($user, $message, $subject, $isPreview)
            );
            return false;
        }
        return ApiResponse::success($users);
    }

    /**
     * Update users by batch
     *
     * @param UpdateUsersRequest $request
     * @param UserRepository $userRepo
     * @return ApiResponse
     */

    public function batchUpdate(UpdateUsersRequest $request, UserRepository $userRepo)
    {
        $users = $request->input('users');
        $results = [];
        foreach ($users as $key => $val) {
            $user = $userRepo->find($val['id']);
            if (array_key_exists('green_token', $val)) {
                $update = $this->updateUserGreenToken($user, $val['green_token'], $val['remarks']);
            } else {
                $isAdmin  = array_key_exists('is_admin', $val) ? $val['is_admin'] : null;
                $isActive = array_key_exists('is_active', $val) ? $val['is_active'] : null;
                $update = $this->update($user, $isActive, $isAdmin);
            }

            if ($update instanceof \Exception) {
                $results[$user->id] = __('users.update.failed', [
                    'name' => $user->name,
                    'id'   => $user->id,
                ]);
            } else {
                $results[$user->id] = __('users.update.success', [
                    'name' => $user->name,
                    'id'   => $user->id,
                ]);
            }
        }
        return ApiResponse::success($results);
    }

    public function batchUpdateRecognize(UpdateUsersRequest $request, UserRepository $userRepo)
    {
        $users = $request->input('users');

        $results = [];

        foreach ($users as $key => $val) {
            $user = $userRepo->find($val['id']);
            if (array_key_exists('black_token', $val)) {
                $update = $this->updateUserBlackToken($user, $val['black_token'], $val['remarks']);
            } else {
                $isAdmin  = array_key_exists('is_admin', $val) ? $val['is_admin'] : null;
                $isActive = array_key_exists('is_active', $val) ? $val['is_active'] : null;
                $update = $this->update($user, $isActive, $isAdmin);
            }

            if ($update instanceof \Exception) {
                $results[$user->id] = __('users.update.failed', [
                    'name' => $user->name,
                    'id'   => $user->id,
                ]);
            } else {
                $results[$user->id] = __('users.update.success', [
                    'name' => $user->name,
                    'id'   => $user->id,
                ]);
            }
        }
        return ApiResponse::success($results);
    }

    /**
     * Update a single user
     *
     * @param User $user
     * @param bool $isActive
     * @param bool $isAdmin
     * @return ApiResponse
     */
    public function update(User $user, $isActive = null, $isAdmin = null)
    {
        $request = request();

        $hasActiveChange = $isActive != $user->is_active;
        $hasAdminChange  = $isAdmin != $user->is_admin;

        //1 - for manual partner; 2 - for manual admin ; 4 - for manual portal access

        try {
            if (! is_null($isAdmin)) {
                $user->is_admin = $isAdmin;

                if ($hasAdminChange) {
                    $user->is_manual =  $user->is_manual | 2;
                }
            }

            if (! is_null($isActive)) {
                $user->is_active = $isActive;

                if ($hasActiveChange) {
                    $user->is_manual =  $user->is_manual | 4;
                }

                if (! $isActive) {
                    $this->invalidateUser($user);
                }
            }


            $user->save();
        } catch (\Exception $e) {
            return $e;
        }

        if (! is_null($isAdmin) && $isAdmin && $hasAdminChange) {
            event(new AdminLogEvent($request->user()->id, AdminLog::TYPE_ADMIN_ACCESS_GRANTED, [
                'admin' => $request->user()->name,
                'user'  => $user->name,
            ]));
        } elseif (! $isAdmin && $hasAdminChange) {
            event(new AdminLogEvent($request->user()->id, AdminLog::TYPE_ADMIN_ACCESS_REVOKED, [
                'admin' => $request->user()->name,
                'user'  => $user->name,
            ]));
        }

        if (! is_null($isActive) && $isActive && $hasActiveChange) {
            event(new AdminLogEvent($request->user()->id, AdminLog::TYPE_PORTAL_ACCESS_GRANTED, [
                'admin' => $request->user()->name,
                'user'  => $user->name,
            ]));
        } elseif (! $isActive && $hasActiveChange) {
            event(new AdminLogEvent($request->user()->id, AdminLog::TYPE_PORTAL_ACCESS_REVOKED, [
                'admin' => $request->user()->name,
                'user'  => $user->name,
            ]));
        }

        return $user;
    }

    public function updateUserGreenToken(User $user, $greenToken, $remarks)
    {
        $request = request();

        $auth   = auth();
        $amount = $greenToken - $user->green_token;
        $action = GreenTokenLog::ACTION_CREDIT;

        if ($greenToken < $user->green_token) {
            $action = GreenTokenLog::ACTION_DEBIT;
        }

        event(new GreenTokenLogEvent(
            $user->id,
            $action,
            GreenTokenLog::TYPE_ADMIN_OVERRIDE,
            $amount,
            $remarks,
            $auth->user()->id
        ));

        if ($action === GreenTokenLog::ACTION_CREDIT) {
            $type = AdminLog::TYPE_USER_TOKEN_TRANSFER;
        } else {
            $type = AdminLog::TYPE_USER_TOKEN_DEDUCT;
        }

        event(new AdminLogEvent($request->user()->id, $type, [
            'admin' => $request->user()->name,
            'amount' => abs($amount),
            'user'  => $user->name,
        ]));

        return $user;
    }
    // Black Token
    public function updateUserBlackToken(User $user, $blackToken, $remarks)
    {
        $request = request();

        $auth   = auth();
        $amount = $blackToken - $user->black_token;
        $action = BlackTokenLog::ACTION_CREDIT;

        if ($blackToken < $user->black_token) {
            $action = BlackTokenLog::ACTION_DEBIT;
        }

        event(new BlackTokenLogEvent(
            $user->id,
            $action,
            BlackTokenLog::TYPE_ADMIN_OVERRIDE,
            $amount,
            $remarks,
            $auth->user()->id
        ));

        if ($action === BlackTokenLog::ACTION_CREDIT) {
            $type = AdminLog::TYPE_USER_TOKEN_TRANSFER_RECOGNIZE;
        } else {
            $type = AdminLog::TYPE_USER_TOKEN_DEDUCT_RECOGNIZE;
        }

        event(new AdminLogEvent($request->user()->id, $type, [
            'admin' => $request->user()->name,
            'amount' => abs($amount),
            'user'  => $user->name,
        ]));

        return $user;
    }

    public function blacklist(BlacklistUsersRequest $request, UserRepository $userRepo)
    {
        $results = DB::transaction(function () use ($request, $userRepo) {
            $file = $request->file('file');
            $fileName = str_random(32) . ".{$file->extension()}";
            $filePath = $request->file->storeAs('blacklists', $fileName);

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

            $spreadsheet = $reader->load(storage_path("app/blacklists/$fileName"));

            $worksheet = $spreadsheet->getActiveSheet();

            $results = [];

            $blacklist = new BlacklistLog();
            $blacklist->created_by = $request->user()->id;
            $blacklist->save();

            foreach ($worksheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();

                foreach ($cellIterator as $cell) {
                    $azure_id = $cell->getValue();

                    $user   = $userRepo->where('azure_id', $azure_id)->first();
                    $update = $this->blacklistUser($azure_id, $user);

                    if ($update instanceof \Exception) {
                        $results[$user->id] = __('users.update.failed', [
                            'name' => $user->name,
                            'id'   => $user->id,
                        ]);
                    } else {
                        $blacklist->users()->attach($user->id);

                        $results[$user->id] = __('users.update.success', [
                            'name' => $user->name,
                            'id'   => $user->id,
                        ]);
                    }
                }
            }

            return $results;
        });

        return ApiResponse::success($results);
    }

    public function blacklistUser($azure_id, $user)
    {
        $request = request();

        try {
            $user->is_active = 0;
            $user->save();
        } catch (\Exception $e) {
            return $e;
        }

        event(new AdminLogEvent($request->user()->id, AdminLog::TYPE_USER_BLOCK, [
            'admin' => $request->user()->name,
            'user'  => $user->name,
        ]));

        return true;
    }

    protected function invalidateUser($user)
    {
        foreach ($user->tokens as $token) {
            $token->revoke();
        }
    }

    //ADDED

    public function userSummary(Request $request, UserRepository $userRepo)
    {
        if ($request->filled('search')) {
            $query = $userRepo->search('name', $request->input('search'));
        } else {
            $query = $userRepo;
        }
        $users = $userRepo->pager($query);
        $users = $this->addTokenExpiration($users);
        $users = $this->getTotalGreenTokenRedeem($users);
        $users = $this->badgeCounter($users);
        if ($users instanceof ApiException) {
            return ApiResponse::exception($users);
        }
        if ($request->has('download')) {
            ini_set('max_execution_time', 1800);
            $xlsx = $this->createSpreadsheetSummary($users);
            event(new AdminLogEvent($request->user()->id, AdminLog::TYPE_ADMIN_DOWNLOAD_X_RECORD, [
                'admin' => $request->user()->name,
                'type' => "User Profiles",
            ]));
            return response()->download($xlsx);
        }
        return ApiResponse::success($users);
    }

    public function generateCsv(Request $request, UserRepository $userRepo)
    {
        ob_end_clean();
        ignore_user_abort(true); // just to be safe
        ob_start();
        $result['success'] = true;
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        ob_end_clean();
        header('Content-Type: application/json');
        header("Connection: close");
        ignore_user_abort(true); // just to be safe
        ob_start();
        echo json_encode(['success' => true]);
        $size = ob_get_length();
        header("Content-Length: $size");
        ob_end_flush(); // Strange behaviour, will not work
        flush();        // Unless both are called !

        if ($request->filled('search')) {
            $query = $userRepo->search('name', $request->input('search'));
        } else {
            $query = $userRepo;
        }
        $request->request->add(['paginate' => 0]);
        $dateGenerated = date("Y-m-d-H-i-s");
        $filename = "data_export_" . $dateGenerated . ".csv";
        $logDownload = new LogDownloads();
        $logDownload->filename = $filename;
        $logDownload->status = 'generating';
        $logDownload->type = 'User Profiles';
        $logDownload->save();
        $now = gmdate("D, d M Y H:i:s");
        $savePath = storage_path("app/reports/$filename");
        $df = fopen($savePath, 'w');
        fputcsv($df, [
            'Name',
            'Department',
            'Designation',
            'Achievement Tier',
            'Country',
            'Career Level',
            'Total No. of "Recognise Others" tokens',
            'Expiry date for "Recognise Others" tokens',
            'Total No. of "My Rewards" tokens',
            'Total No. of "My Rewards" tokens expiring this month',
            'Total No. of "My Rewards" redeemed ',
        ]);
        $request->merge(['paginate' => 1]);
        $rpp = 2000;
        $request->merge(['rpp' => 1]);
        $result = $userRepo->pager($query);
        $total = $result->total();
        $perPage = $rpp;
        $request->merge(['rpp' => 2000]);
        $userCache = [];
        for ($page = 0; $page <= $total; $page = $page + $perPage) {
            $pageVal = intval($total / ($page + $perPage)) + 1;
            $request->merge(['page' => $pageVal]);
            $result = $userRepo->pager($query);

            foreach ($result as $key => $data) {
                if (!isset($userCache[$data['id']])) {
                    $data['tokens_expiring_this_month'] = $this->addUserTokenExpiration($data);
                    $data['total_green_token_redeem'] = $this->addUserTokenRedeem($data);
                    $userCache[$data['id']]['tokens_expiring_this_month'] = $data['tokens_expiring_this_month'];
                    $userCache[$data['id']]['total_green_token_redeem'] = $data['total_green_token_redeem'];
                    $badges = $this->countUserBadges($data);
                    $userCache[$data['id']]['badge_count'] = $badges;
                    $userCache[$data['id']]['achievement_tier'] = $this->setUserTier($badges);
                    $data['achievement_tier'] = $userCache[$data['id']]['achievement_tier'];
                } else {
                    $data['tokens_expiring_this_month'] = $userCache[$data['id']]['tokens_expiring_this_month'];
                    $data['total_green_token_redeem'] = $userCache[$data['id']]['total_green_token_redeem'];
                    $data['badge_count'] = $userCache[$data['id']]['badge_count'];
                    $data['achievement_tier'] = $userCache[$data['id']]['achievement_tier'];
                }
                $row = [
                    $data->name,
                    $data->department_name,
                    $data->position_name,
                    $data->achievement_tier,
                    $this->countryCodeToCountry($data->country),
                    $data->career_level,
                    $data->black_token,
                    $data->nearest_token_expiration,
                    $data->green_token,
                    $data->tokens_expiring_this_month,
                    $data->total_green_token_redeem,
                ];
                fputcsv($df, $row);
            }
        }
        fclose($df);
        $logDownload->status = 'ready';
        $logDownload->save();

        $user = $request->user();
        $message = 'User Profile report generated at ' . $logDownload->created_at . ' is ready.';
        $subject = 'User Profile Report Generation Process Complete';
        $isPreview = false;
        $admin = $request->user();
        $user = $request->user();
        Mail::to($admin->email)->send(
            new AdminLogMail($user, $message, $subject, $isPreview)
        );
    }

    public function createSpreadsheet($data)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $this->setSpreadsheetHeader($sheet);

        for ($x = 0; $x < count($data); $x++) {
            $this->setSpreadsheetRow($sheet, ($x+2), $data[$x]);
        }

        $xlsx = new Xlsx($spreadsheet);

        $filename = $this->setSpreadsheetFilename();

        $savePath = storage_path("app/reports/$filename");

        $xlsx->save($savePath);

        return $savePath;
    }

    public function setSpreadsheetHeader($sheet)
    {
        $sheet->setCellValue('A1', 'NAME');
        $sheet->setCellValue('B1', 'DEPARTMENT');
        $sheet->setCellValue('C1', 'DESIGNATION');
        $sheet->setCellValue('D1', 'COUNTRY');
        $sheet->setCellValue('E1', 'CAREER LEVEL');
        $sheet->setCellValue('F1', 'PORTAL ACCESS');
        $sheet->setCellValue('G1', 'ADMIN ACCESS');
    }

    public function setSpreadsheetRow($sheet, $row, $data)
    {
        ///$date = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->toDateString();
        //$time = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('H:i:s');
        $sheet->setCellValue("A$row", $data->name);
        $sheet->setCellValue("B$row", $data->department_name);
        $sheet->setCellValue("C$row", $data->position_name);

        $sheet->setCellValue("D$row", $this->countryCodeToCountry($data->country));
        // $sheet->setCellValue("D$row", $data->country);

        $sheet->setCellValue("E$row", $data->career_level);
        $sheet->setCellValue("F$row", $data->is_active);
        $sheet->setCellValue("G$row", $data->is_admin);
    }


    // SUMMARY

    public function createSpreadsheetSummary($data)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $this->setSpreadsheetHeaderSummary($sheet);

        for ($x = 0; $x < count($data); $x++) {
            $this->setSpreadsheetRowSummary($sheet, ($x+2), $data[$x]);
        }

        $xlsx = new Xlsx($spreadsheet);

        $filename = $this->setSpreadsheetFilename();

        $savePath = storage_path("app/reports/$filename");

        $xlsx->save($savePath);

        return $savePath;
    }
    public function setSpreadsheetHeaderSummary($sheet)
    {
        $sheet->setCellValue('A1', 'Date');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Department');
        $sheet->setCellValue('D1', 'Designation');
        $sheet->setCellValue('E1', 'Achievement Tier');
        $sheet->setCellValue('F1', 'Country'); // added sept 23 2020
        $sheet->setCellValue('G1', 'Career Level');
        $sheet->setCellValue('H1', 'Total No. of "Recognise Others" tokens');
        $sheet->setCellValue('I1', 'Expiry date for "Recognise Others" tokens');
        $sheet->setCellValue('J1', 'Total No. of "My Rewards" tokens');
        $sheet->setCellValue('K1', 'Total No. of "My Rewards" tokens expiring this month');
        $sheet->setCellValue('L1', 'Total No. of "My Rewards" redeemed ');
    }

    public function setSpreadsheetRowSummary($sheet, $row, $data)
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', now())->toDateString();
        $sheet->setCellValue("A$row", $date);
        $sheet->setCellValue("B$row", $data->name);
        $sheet->setCellValue("C$row", $data->department_name);
        $sheet->setCellValue("D$row", $data->position_name);
        $sheet->setCellValue("E$row", $data->achievement_tier);
        $sheet->setCellValue("F$row", $this->countryCodeToCountry($data->country));
        $sheet->setCellValue("G$row", $data->career_level);
        $sheet->setCellValue("H$row", $data->black_token);
        $sheet->setCellValue("I$row", $data->nearest_token_expiration);
        $sheet->setCellValue("J$row", $data->green_token);
        $sheet->setCellValue("K$row", $data->tokens_expiring_this_month);
        $sheet->setCellValue("L$row", $data->total_green_token_redeem);
    }

    public function setSpreadsheetFilename()
    {
        $dt = date('YMD_His');

        $result = "user_access_$dt.xlsx";

        return $result;
    }

    public function addTokenExpiration($data)
    {
        $nearestToken = Carbon::now()
            ->addQuarter(1)
            ->firstOfQuarter()
            ->hour(0)
            ->minute(0)
            ->second(0)
            ->toDateTimeString();
        $userCache = [];
        $cnt = count($data);
        for ($x = 0; $x < $cnt; $x++) {
            if (!isset($userCache[$data[$x]['id']])) {
                $tokensum = $this->addUserTokenExpiration($data[$x]);
                $userCache[$data[$x]['id']] = $tokensum;
            } else {
                $tokensum = $userCache[$data[$x]['id']];
            }
            if ($tokensum < 0) {
                $tokensum = 0;
            }
            $data[$x]['tokens_expiring_this_month'] = $tokensum;
            $data[$x]['nearest_token_expiration'] = $nearestToken;
        }
        return $data;
    }

    public function addUserTokenExpiration($user)
    {
        $tokensum = GreenTokenLog::where('user_id', ($user['id']))->
                               whereMonth('expires_at', '=', now()->month)->
                               sum('amount');

        if($tokensum<0){
            $tokensum = 0;
        }

        return $tokensum;
    }



    public function addNearestTokenExpiration($date)
    {
        return Carbon::$date->addMonth(3)->toDateString();
    }

    public function badgeCounter($data)
    {
        $cnt = count($data);
        $userCache = [];
        for ($x = 0; $x < $cnt; $x++) {
            if (!isset($userCache[$data[$x]['id']])) {
                $badges = $this->countUserBadges($data[$x]);
                $userCache[$data[$x]['id']] = $badges;
            } else {
                $badges = $userCache[$data[$x]['id']];
            }
            $data[$x]['badge_count'] = $badges;
            $data[$x]['achievement_tier'] = $this->setUserTier($badges);
        }
        return $data;
    }

    public function countUserBadges($user)
    {
        return MessageBadge::selectRaw('id')->
                             where('recipient_user_id', $user['id'])->
                             get()->count();
    }

    public function setUserTier($badges)
    {
        if ($badges < 0) {
            return "";
        } elseif ($badges > 0 && $badges <= 60) {
            return "Rising Star";
        } elseif ($badges >= 61  && $badges <= 240) {
            return "Shining Star";
        } elseif ($badges >= 241  && $badges <= 480) {
            return "Shooting Star";
        } elseif ($badges >= 481  && $badges <= 800) {
            return "Superstar";
        } elseif ($badges > 800) {
            return "Megastar";
        }
    }

    public function getTotalGreenTokenRedeem($data)
    {
        $cnt = count($data);
        $userCache = [];
        for ($x = 0; $x < $cnt; $x++) {
            if (!isset($userCache[$data[$x]['id']])) {
                $tokensum = $this->addUserTokenRedeem($data[$x]);
                $userCache[$data[$x]['id']] = $tokensum;
            } else {
                $tokensum = $userCache[$data[$x]['id']];
            }

            if ($tokensum < 0) {
                $tokensum = 0;
            }
            $data[$x]['total_green_token_redeem'] = abs($tokensum);
            // $data[$x]['total_green_token_redeem'] = $tokensum;

        }
        return $data;
    }

    public function addUserTokenRedeem($user)
    {
        $token = GreenTokenLog::where('user_id', ($user['id']))->
                               where('type', '=', GreenTokenLog::TYPE_REDEEM)->
                               sum('amount');

        $token = abs($token);
        return $token;
    }

    public function countryCodeToCountry($code)
    {
        $code = strtoupper($code);
        if ($code == 'AF') {
            return 'Afghanistan';
        }
        if ($code == 'AX') {
            return 'Aland Islands';
        }
        if ($code == 'AL') {
            return 'Albania';
        }
        if ($code == 'DZ') {
            return 'Algeria';
        }
        if ($code == 'AS') {
            return 'American Samoa';
        }
        if ($code == 'AD') {
            return 'Andorra';
        }
        if ($code == 'AO') {
            return 'Angola';
        }
        if ($code == 'AI') {
            return 'Anguilla';
        }
        if ($code == 'AQ') {
            return 'Antarctica';
        }
        if ($code == 'AG') {
            return 'Antigua and Barbuda';
        }
        if ($code == 'AR') {
            return 'Argentina';
        }
        if ($code == 'AM') {
            return 'Armenia';
        }
        if ($code == 'AW') {
            return 'Aruba';
        }
        if ($code == 'AU') {
            return 'Australia';
        }
        if ($code == 'AT') {
            return 'Austria';
        }
        if ($code == 'AZ') {
            return 'Azerbaijan';
        }
        if ($code == 'BS') {
            return 'Bahamas the';
        }
        if ($code == 'BH') {
            return 'Bahrain';
        }
        if ($code == 'BD') {
            return 'Bangladesh';
        }
        if ($code == 'BB') {
            return 'Barbados';
        }
        if ($code == 'BY') {
            return 'Belarus';
        }
        if ($code == 'BE') {
            return 'Belgium';
        }
        if ($code == 'BZ') {
            return 'Belize';
        }
        if ($code == 'BJ') {
            return 'Benin';
        }
        if ($code == 'BM') {
            return 'Bermuda';
        }
        if ($code == 'BT') {
            return 'Bhutan';
        }
        if ($code == 'BO') {
            return 'Bolivia';
        }
        if ($code == 'BA') {
            return 'Bosnia and Herzegovina';
        }
        if ($code == 'BW') {
            return 'Botswana';
        }
        if ($code == 'BV') {
            return 'Bouvet Island (Bouvetoya)';
        }
        if ($code == 'BR') {
            return 'Brazil';
        }
        if ($code == 'IO') {
            return 'British Indian Ocean Territory (Chagos Archipelago)';
        }
        if ($code == 'VG') {
            return 'British Virgin Islands';
        }
        if ($code == 'BN') {
            return 'Brunei Darussalam';
        }
        if ($code == 'BG') {
            return 'Bulgaria';
        }
        if ($code == 'BF') {
            return 'Burkina Faso';
        }
        if ($code == 'BI') {
            return 'Burundi';
        }
        if ($code == 'KH') {
            return 'Cambodia';
        }
        if ($code == 'CM') {
            return 'Cameroon';
        }
        if ($code == 'CA') {
            return 'Canada';
        }
        if ($code == 'CV') {
            return 'Cape Verde';
        }
        if ($code == 'KY') {
            return 'Cayman Islands';
        }
        if ($code == 'CF') {
            return 'Central African Republic';
        }
        if ($code == 'TD') {
            return 'Chad';
        }
        if ($code == 'CL') {
            return 'Chile';
        }
        if ($code == 'CN') {
            return 'China';
        }
        if ($code == 'CX') {
            return 'Christmas Island';
        }
        if ($code == 'CC') {
            return 'Cocos (Keeling) Islands';
        }
        if ($code == 'CO') {
            return 'Colombia';
        }
        if ($code == 'KM') {
            return 'Comoros the';
        }
        if ($code == 'CD') {
            return 'Congo';
        }
        if ($code == 'CG') {
            return 'Congo the';
        }
        if ($code == 'CK') {
            return 'Cook Islands';
        }
        if ($code == 'CR') {
            return 'Costa Rica';
        }
        if ($code == 'CI') {
            return 'Cote d\'Ivoire';
        }
        if ($code == 'HR') {
            return 'Croatia';
        }
        if ($code == 'CU') {
            return 'Cuba';
        }
        if ($code == 'CY') {
            return 'Cyprus';
        }
        if ($code == 'CZ') {
            return 'Czech Republic';
        }
        if ($code == 'DK') {
            return 'Denmark';
        }
        if ($code == 'DJ') {
            return 'Djibouti';
        }
        if ($code == 'DM') {
            return 'Dominica';
        }
        if ($code == 'DO') {
            return 'Dominican Republic';
        }
        if ($code == 'EC') {
            return 'Ecuador';
        }
        if ($code == 'EG') {
            return 'Egypt';
        }
        if ($code == 'SV') {
            return 'El Salvador';
        }
        if ($code == 'GQ') {
            return 'Equatorial Guinea';
        }
        if ($code == 'ER') {
            return 'Eritrea';
        }
        if ($code == 'EE') {
            return 'Estonia';
        }
        if ($code == 'ET') {
            return 'Ethiopia';
        }
        if ($code == 'FO') {
            return 'Faroe Islands';
        }
        if ($code == 'FK') {
            return 'Falkland Islands (Malvinas)';
        }
        if ($code == 'FJ') {
            return 'Fiji the Fiji Islands';
        }
        if ($code == 'FI') {
            return 'Finland';
        }
        if ($code == 'FR') {
            return 'France, French Republic';
        }
        if ($code == 'GF') {
            return 'French Guiana';
        }
        if ($code == 'PF') {
            return 'French Polynesia';
        }
        if ($code == 'TF') {
            return 'French Southern Territories';
        }
        if ($code == 'GA') {
            return 'Gabon';
        }
        if ($code == 'GM') {
            return 'Gambia the';
        }
        if ($code == 'GE') {
            return 'Georgia';
        }
        if ($code == 'DE') {
            return 'Germany';
        }
        if ($code == 'GH') {
            return 'Ghana';
        }
        if ($code == 'GI') {
            return 'Gibraltar';
        }
        if ($code == 'GR') {
            return 'Greece';
        }
        if ($code == 'GL') {
            return 'Greenland';
        }
        if ($code == 'GD') {
            return 'Grenada';
        }
        if ($code == 'GP') {
            return 'Guadeloupe';
        }
        if ($code == 'GU') {
            return 'Guam';
        }
        if ($code == 'GT') {
            return 'Guatemala';
        }
        if ($code == 'GG') {
            return 'Guernsey';
        }
        if ($code == 'GN') {
            return 'Guinea';
        }
        if ($code == 'GW') {
            return 'Guinea-Bissau';
        }
        if ($code == 'GY') {
            return 'Guyana';
        }
        if ($code == 'HT') {
            return 'Haiti';
        }
        if ($code == 'HM') {
            return 'Heard Island and McDonald Islands';
        }
        if ($code == 'VA') {
            return 'Holy See (Vatican City State)';
        }
        if ($code == 'HN') {
            return 'Honduras';
        }
        if ($code == 'HK') {
            return 'Hong Kong';
        }
        if ($code == 'HU') {
            return 'Hungary';
        }
        if ($code == 'IS') {
            return 'Iceland';
        }
        if ($code == 'IN') {
            return 'India';
        }
        if ($code == 'ID') {
            return 'Indonesia';
        }
        if ($code == 'IR') {
            return 'Iran';
        }
        if ($code == 'IQ') {
            return 'Iraq';
        }
        if ($code == 'IE') {
            return 'Ireland';
        }
        if ($code == 'IM') {
            return 'Isle of Man';
        }
        if ($code == 'IL') {
            return 'Israel';
        }
        if ($code == 'IT') {
            return 'Italy';
        }
        if ($code == 'JM') {
            return 'Jamaica';
        }
        if ($code == 'JP') {
            return 'Japan';
        }
        if ($code == 'JE') {
            return 'Jersey';
        }
        if ($code == 'JO') {
            return 'Jordan';
        }
        if ($code == 'KZ') {
            return 'Kazakhstan';
        }
        if ($code == 'KE') {
            return 'Kenya';
        }
        if ($code == 'KI') {
            return 'Kiribati';
        }
        if ($code == 'KP') {
            return 'Korea';
        }
        if ($code == 'KR') {
            return 'Korea';
        }
        if ($code == 'KW') {
            return 'Kuwait';
        }
        if ($code == 'KG') {
            return 'Kyrgyz Republic';
        }
        if ($code == 'LA') {
            return 'Lao';
        }
        if ($code == 'LV') {
            return 'Latvia';
        }
        if ($code == 'LB') {
            return 'Lebanon';
        }
        if ($code == 'LS') {
            return 'Lesotho';
        }
        if ($code == 'LR') {
            return 'Liberia';
        }
        if ($code == 'LY') {
            return 'Libyan Arab Jamahiriya';
        }
        if ($code == 'LI') {
            return 'Liechtenstein';
        }
        if ($code == 'LT') {
            return 'Lithuania';
        }
        if ($code == 'LU') {
            return 'Luxembourg';
        }
        if ($code == 'MO') {
            return 'Macao';
        }
        if ($code == 'MK') {
            return 'Macedonia';
        }
        if ($code == 'MG') {
            return 'Madagascar';
        }
        if ($code == 'MW') {
            return 'Malawi';
        }
        if ($code == 'MY') {
            return 'Malaysia';
        }
        if ($code == 'MV') {
            return 'Maldives';
        }
        if ($code == 'ML') {
            return 'Mali';
        }
        if ($code == 'MT') {
            return 'Malta';
        }
        if ($code == 'MH') {
            return 'Marshall Islands';
        }
        if ($code == 'MQ') {
            return 'Martinique';
        }
        if ($code == 'MR') {
            return 'Mauritania';
        }
        if ($code == 'MU') {
            return 'Mauritius';
        }
        if ($code == 'YT') {
            return 'Mayotte';
        }
        if ($code == 'MX') {
            return 'Mexico';
        }
        if ($code == 'FM') {
            return 'Micronesia';
        }
        if ($code == 'MD') {
            return 'Moldova';
        }
        if ($code == 'MC') {
            return 'Monaco';
        }
        if ($code == 'MN') {
            return 'Mongolia';
        }
        if ($code == 'ME') {
            return 'Montenegro';
        }
        if ($code == 'MS') {
            return 'Montserrat';
        }
        if ($code == 'MA') {
            return 'Morocco';
        }
        if ($code == 'MZ') {
            return 'Mozambique';
        }
        if ($code == 'MM') {
            return 'Myanmar';
        }
        if ($code == 'NA') {
            return 'Namibia';
        }
        if ($code == 'NR') {
            return 'Nauru';
        }
        if ($code == 'NP') {
            return 'Nepal';
        }
        if ($code == 'AN') {
            return 'Netherlands Antilles';
        }
        if ($code == 'NL') {
            return 'Netherlands the';
        }
        if ($code == 'NC') {
            return 'New Caledonia';
        }
        if ($code == 'NZ') {
            return 'New Zealand';
        }
        if ($code == 'NI') {
            return 'Nicaragua';
        }
        if ($code == 'NE') {
            return 'Niger';
        }
        if ($code == 'NG') {
            return 'Nigeria';
        }
        if ($code == 'NU') {
            return 'Niue';
        }
        if ($code == 'NF') {
            return 'Norfolk Island';
        }
        if ($code == 'MP') {
            return 'Northern Mariana Islands';
        }
        if ($code == 'NO') {
            return 'Norway';
        }
        if ($code == 'OM') {
            return 'Oman';
        }
        if ($code == 'PK') {
            return 'Pakistan';
        }
        if ($code == 'PW') {
            return 'Palau';
        }
        if ($code == 'PS') {
            return 'Palestinian Territory';
        }
        if ($code == 'PA') {
            return 'Panama';
        }
        if ($code == 'PG') {
            return 'Papua New Guinea';
        }
        if ($code == 'PY') {
            return 'Paraguay';
        }
        if ($code == 'PE') {
            return 'Peru';
        }
        if ($code == 'PH') {
            return 'Philippines';
        }
        if ($code == 'PN') {
            return 'Pitcairn Islands';
        }
        if ($code == 'PL') {
            return 'Poland';
        }
        if ($code == 'PT') {
            return 'Portugal, Portuguese Republic';
        }
        if ($code == 'PR') {
            return 'Puerto Rico';
        }
        if ($code == 'QA') {
            return 'Qatar';
        }
        if ($code == 'RE') {
            return 'Reunion';
        }
        if ($code == 'RO') {
            return 'Romania';
        }
        if ($code == 'RU') {
            return 'Russian Federation';
        }
        if ($code == 'RW') {
            return 'Rwanda';
        }
        if ($code == 'BL') {
            return 'Saint Barthelemy';
        }
        if ($code == 'SH') {
            return 'Saint Helena';
        }
        if ($code == 'KN') {
            return 'Saint Kitts and Nevis';
        }
        if ($code == 'LC') {
            return 'Saint Lucia';
        }
        if ($code == 'MF') {
            return 'Saint Martin';
        }
        if ($code == 'PM') {
            return 'Saint Pierre and Miquelon';
        }
        if ($code == 'VC') {
            return 'Saint Vincent and the Grenadines';
        }
        if ($code == 'WS') {
            return 'Samoa';
        }
        if ($code == 'SM') {
            return 'San Marino';
        }
        if ($code == 'ST') {
            return 'Sao Tome and Principe';
        }
        if ($code == 'SA') {
            return 'Saudi Arabia';
        }
        if ($code == 'SN') {
            return 'Senegal';
        }
        if ($code == 'RS') {
            return 'Serbia';
        }
        if ($code == 'SC') {
            return 'Seychelles';
        }
        if ($code == 'SL') {
            return 'Sierra Leone';
        }
        if ($code == 'SG') {
            return 'Singapore';
        }
        if ($code == 'SK') {
            return 'Slovakia (Slovak Republic)';
        }
        if ($code == 'SI') {
            return 'Slovenia';
        }
        if ($code == 'SB') {
            return 'Solomon Islands';
        }
        if ($code == 'SO') {
            return 'Somalia, Somali Republic';
        }
        if ($code == 'ZA') {
            return 'South Africa';
        }
        if ($code == 'GS') {
            return 'South Georgia and the South Sandwich Islands';
        }
        if ($code == 'ES') {
            return 'Spain';
        }
        if ($code == 'LK') {
            return 'Sri Lanka';
        }
        if ($code == 'SD') {
            return 'Sudan';
        }
        if ($code == 'SR') {
            return 'Suriname';
        }
        if ($code == 'SJ') {
            return 'Svalbard & Jan Mayen Islands';
        }
        if ($code == 'SZ') {
            return 'Swaziland';
        }
        if ($code == 'SE') {
            return 'Sweden';
        }
        if ($code == 'CH') {
            return 'Switzerland, Swiss Confederation';
        }
        if ($code == 'SY') {
            return 'Syrian Arab Republic';
        }
        if ($code == 'TW') {
            return 'Taiwan';
        }
        if ($code == 'TJ') {
            return 'Tajikistan';
        }
        if ($code == 'TZ') {
            return 'Tanzania';
        }
        if ($code == 'TH') {
            return 'Thailand';
        }
        if ($code == 'TL') {
            return 'Timor-Leste';
        }
        if ($code == 'TG') {
            return 'Togo';
        }
        if ($code == 'TK') {
            return 'Tokelau';
        }
        if ($code == 'TO') {
            return 'Tonga';
        }
        if ($code == 'TT') {
            return 'Trinidad and Tobago';
        }
        if ($code == 'TN') {
            return 'Tunisia';
        }
        if ($code == 'TR') {
            return 'Turkey';
        }
        if ($code == 'TM') {
            return 'Turkmenistan';
        }
        if ($code == 'TC') {
            return 'Turks and Caicos Islands';
        }
        if ($code == 'TV') {
            return 'Tuvalu';
        }
        if ($code == 'UG') {
            return 'Uganda';
        }
        if ($code == 'UA') {
            return 'Ukraine';
        }
        if ($code == 'AE') {
            return 'United Arab Emirates';
        }
        if ($code == 'GB') {
            return 'United Kingdom';
        }
        if ($code == 'US') {
            return 'United States of America';
        }
        if ($code == 'UM') {
            return 'United States Minor Outlying Islands';
        }
        if ($code == 'VI') {
            return 'United States Virgin Islands';
        }
        if ($code == 'UY') {
            return 'Uruguay, Eastern Republic of';
        }
        if ($code == 'UZ') {
            return 'Uzbekistan';
        }
        if ($code == 'VU') {
            return 'Vanuatu';
        }
        if ($code == 'VE') {
            return 'Venezuela';
        }
        if ($code == 'VN') {
            return 'Vietnam';
        }
        if ($code == 'WF') {
            return 'Wallis and Futuna';
        }
        if ($code == 'EH') {
            return 'Western Sahara';
        }
        if ($code == 'YE') {
            return 'Yemen';
        }
        if ($code == 'XK') {
            return 'Kosovo';
        }
        if ($code == 'ZM') {
            return 'Zambia';
        }
        if ($code == 'ZW') {
            return 'Zimbabwe';
        }
        return '';
    }
}
