<?php

namespace App\Http\Controllers\Admin;

use App\Events\AdminLogEvent;
use App\Http\Controllers\BaseEdmController;
use App\Http\Requests\Admin\Edm\CsvImportRequest;
use App\Http\Requests\Admin\Edm\StoreEdmRequest;
use App\Mail\AdminLogMail;
use App\Mail\MonthlySummaryMail;
use App\Models\AdminLog;
use App\Models\Edm;
use App\Models\EdmCsvMassUpload;
use App\Models\EdmLog;
use App\Models\EdmTemplateBody;
use App\Models\LogDownloads;
use App\Models\User;
use App\Repositories\EdmFileRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

class EdmController extends BaseEdmController
{
    public function index(Request $request, EdmFileRepository $edmFileRepo)
    {
        $query  = $edmFileRepo->where('is_active', 1);
        $result = $edmFileRepo->pager($query);

        if ($result instanceof \Exception) {
            return ApiResponse::exception(ApiException::serverError($result->getMessage()));
        }

        return ApiResponse::success($result);
    }

    public function store(StoreEdmRequest $request, EdmFileRepository $edmFileRepo)
    {
        try {
            DB::beginTransaction();

            $edm = Edm::find($request->input('id'));

            $file = $edmFileRepo->upload();

            if ($file instanceof \Exception) {
                throw $file;
            }

            // deactivate all existing file for the given edm type
            $edmFileRepo->where('edm_id', $request->input('id'))->update([
                'is_active' => 0,
            ]);

            // create new edm file for new upload
            $edmFile = $edmFileRepo->create([
                'edm_id' => $request->input('id'),
                'file'   => $file,
                'is_active' => 1,
            ]);

            if ($edmFile instanceof \Exception) {
                throw $edmFile;
            }

            event(new AdminLogEvent($request->user()->id, AdminLog::TYPE_EDM_UPDATE, [
                'user' => $request->user()->name,
            ]));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::exception(ApiException::serverError($e->getMessage()));
        }

        return ApiResponse::success($edmFile);
    }

    public function preview($edm_id, Request $request, EdmFileRepository $edmFileRepo)
    {
        $isPreview = false;

        if (! $request->has('send')) {
            $isPreview = true;
        }

        $user = $request->user();

        if ($edm_id < 8) {
            $edmFile = $edmFileRepo->where(['edm_id' => $edm_id, 'is_active' => 1])->first();
            $edmFile->setAppends(['blade_path']);
        }



        /*
        edm_id
        id  name

        1 Message Send
        2 Message Received
        3 Redemption
        4 Welcome
        5 Message Send Token
        6 Message Received Token
        7 Monthly Summary

        */



        switch ($edm_id) {
            case 1:
                //
                $content = $this->generateSendPreview(
                    $request->user()->id,
                    $request->input('message'),
                    $request->input('badge_id'),
                    $request->input('user_id'),
                    null,
                    $isPreview,
                    false,
                    $editpreview = ($request->input('editpreview')) ? true:false,
                    $request->input('content')
                );

                break;
            case 2:
                $content = $this->generateReceivePreview(
                    $request->user()->id,
                    $request->input('message'),
                    $request->input('badge_id'),
                    $request->input('user_id'),
                    null,
                    $isPreview,
                    false,
                    $editpreview = ($request->input('editpreview')) ? true:false,
                    $request->input('content')
                );
                break;
            case 3:

                //Redemption
                $content = $this->generateRedeemPreview(
                    $request->user()->id,
                    $request->input('orderItems'),
                    $isPreview,
                    $editpreview = ($request->input('editpreview')) ? true:false,
                    $request->input('content')
                );
                break;
            case 4:

                $content = $this->generateWelcomePreview(
                    $request->user()->id,
                    $request->input('content'),
                    $request->input('badge_id'),
                    $request->input('user_id'),
                    $request->input('token'),
                    $isPreview,
                    true,
                    $editpreview = ($request->input('editpreview')) ? true:false
                );
                break;



            case 5:
                $content = $this->generateReceivePreview(
                    $request->user()->id,
                    $request->input('message'),
                    $request->input('badge_id'),
                    $request->input('user_id'),
                    $request->input('token'),
                    $isPreview,
                    true,
                    $editpreview = ($request->input('editpreview')) ? true:false,
                    $request->input('content')
                );
                break;

            case 6:
                //
                $content = $this->generateSendPreview(
                    $request->user()->id,
                    $request->input('message'),
                    $request->input('badge_id'),
                    $request->input('user_id'),
                    $request->input('token'),
                    $isPreview,
                    true,
                    $editpreview = ($request->input('editpreview')) ? true:false,
                    $request->input('content')
                );

                break;


            case 7:
                //Monthly Summary
                $content = $this->generateMonthlySummaryPreview(
                    $request->user()->id,
                    $request->input('message'),
                    $request->input('badge_id'),
                    $request->input('user_id'),
                    $request->input('token'),
                    $isPreview,
                    true,
                    $request->input('content'),
                    $editpreview = ($request->input('editpreview')) ? true:false
                );
                    // $editpreview = ($request->input('editpreview')) ? true:false
                break;

            case 8:

                //Tier Promotion
                $content = $this->generateTierPromotionPreview(
                    $request->user()->id,
                    // $request->input('message'),
                    $request->input('content'),
                    // $request->input('message'),
                    $request->input('badge_id'),
                    $request->input('user_id'),
                    $request->input('token'),
                    $isPreview,
                    true,
                    $editpreview = ($request->input('editpreview')) ? true:false
                );

                break;
            case 9:

                //masstokenupdate

               $admin = $request->user();

                $content = $this->generatemasstokenupdatePreview(
                    $request->user()->id,
                    $email = 'test@gmail.com',
                    $isPreview,
                    $edm_id,
                    $admin,
                    $message = null,
                    $RO_deduct = null,
                    $RO_add = null,
                    $MR_deduct=null,
                    $MR_add = null,
                    $editpreview = ($request->input('editpreview')) ? true:false,
                    $content = $request->input('content')
                );
                break;

            default:

                $admin = $request->user();
                //Universal Edm template
                $content = $this->generateUniversalPreview(
                    $request->user()->id,
                    $email = 'test@gmail.com',
                    $isPreview,
                    $edm_id,
                    $admin,
                    $editpreview = ($request->input('editpreview')) ? true:false,
                    $message = $request->input('content')
                );
        }

        if (!$request->has('send')) {
            return $content;
        }

        if ($isPreview) {
            return $content;
        }

        try {
            Mail::to($request->send)->send($content);
        } catch (\Exception $e) {
            return ApiResponse::exception(ApiException::serverError($e->getMessage()));
        }

        return ApiResponse::success();
    }


    public function sendBlast($edm_id, Request $request)
    {
        $emails = [];
        if (!$request->has('emails') && !$request->file('emailFile')) {
            $isPreview = true;
        } elseif ($request->has('emails')) {
            $emails = explode(',', $request->input('emails'));
        } else {
            $emailCsv = $request->file('emailFile');
            $content = file_get_contents($emailCsv->getRealPath());
            $emails = explode('\n', $content);
        }
        $email_recurrence_count = array_count_values($emails);
        $duplicated = array_filter($email_recurrence_count, function ($value) {
            return $value > 1;
        });
        $emails = array_unique($emails);
        $RESERVED_EDMS = 9;
        $existing = 0;
        $missing = 0;
        $unique_email_count = count($emails);
        $duplicate_email_count = count($duplicated);
        if ($edm_id >= $RESERVED_EDMS) {
            foreach ($emails as $email) {
                $admin = $request->user();
                $user = User::where('email', trim($email))->first();

                if ($user) {
                    $content = $this->generateUniversalPreview(
                        $user->id,
                        $user->email,
                        false,
                        $edm_id,
                        $admin,
                        false,
                        $message = ''
                    );
                    Mail::to($user->email)->send($content);
                    // try {
                    // } catch (\Exception $e) {
                    // }
                    $existing = $existing + 1;
                } else {
                    $missing = $missing + 1;
                }
            }
        }
        return ApiResponse::success([
            'existing' => $existing,
            'missing' => $missing,
            'unique_email_count' => $unique_email_count,
            'duplicate_email_count' => $duplicate_email_count
        ]);
    }

    public function getLogs(Request $request)
    {
        $edmLogs = new EdmLog();
        if ($request->has('download')) {
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
            event(new AdminLogEvent($request->user()->id, AdminLog::TYPE_EDM_SENTLOGS_DOWNLOAD, [
                  'admin' => $request->user()->name,
            ]));
            ini_set('max_execution_time', 1800);
            $request->request->add(['paginate' => 0]);
            $dateGenerated = date("Y-m-d-H-i-s");
            $filename = "data_export_" . $dateGenerated . ".csv";
            $logDownload = new LogDownloads();
            $logDownload->filename = $filename;
            $logDownload->status = 'generating';
            $logDownload->type = 'EDM Sent Logs';
            $logDownload->save();
            $now = gmdate("D, d M Y H:i:s");
            $savePath = storage_path("app/reports/$filename");
            $df = fopen($savePath, 'w');
            fputcsv($df, [
                'Sender Name',
                'Sender Email',
                'Recipient Name',
                'Recipient E-mail',
                'EDM Subject',
                'Edm Type',
                'Send Date',
            ]);
            $request->merge(['paginate' => 1]);
            $rpp = 2000;
            $request->merge(['rpp' => 1]);
            $result = $edmLogs->pager($edmLogs);
            $total = $result->total();
            $perPage = $rpp;
            $request->merge(['rpp' => 2000]);
            $userCache = [];
            for ($page = 0; $page <= $total; $page = $page + $perPage) {
                $pageVal = intval($total / ($page + $perPage)) + 1;
                $request->merge(['page' => $pageVal]);
                $result = $edmLogs->pager($edmLogs);
                $result = $this->formatResults($result);
                foreach ($result as $key => $data) {
                    $row = [
                        $data->sender,
                        $data->sender_email,
                        $data->recipient,
                        $data->recipient_email,
                        $data->edm_subject,
                        $data->type,
                        $data->created_at,
                    ];
                    fputcsv($df, $row);
                }
            }
            fclose($df);
            $logDownload->status = 'ready';
            $logDownload->save();
            $user = $request->user();
            $message = 'EDM Sent logs report generated at ' . $logDownload->created_at . ' is ready.';
            $subject = 'EDM Sent Logs Report Generation Process Complete';
            $isPreview = false;
            $admin = $request->user();
            $user = $request->user();
            Mail::to($admin->email)->send(
                new AdminLogMail($user, $message, $subject, $isPreview)
            );
            die();
        }
        $items = $edmLogs->pager($edmLogs);
        $items = $this->formatResults($items);
        return ApiResponse::success($items);
    }

    public function formatResults($items)
    {

        foreach ($items as $key => $item) {
            /*
                edm_id
                id  name
                1 Message Send
                2 Message Received
                3 Redemption
                4 Welcome
                5 Message Send Token
                6 Message Received Token
                7 Monthly Summary

            */
            $items[$key]['type_id'] = $item['type'];
            switch ($item['type']) {
                case 1:
                case 2:
                case 3:
                case 4:
                case 5:
                case 6:
                case 7:
                    $items[$key]['type'] = Edm::find($item['type'])->name;
                    break;
                case 8:
                    $items[$key]['type'] = "TIER Promotion";
                    break;
                case 9:
                    // $items[$key]['type'] = "EMAIL BLAST";
                    $items[$key]['type'] = "CUSTOM EDM";
                    break;
                case 10:
                    $items[$key]['type'] = "MASS TOKEN UPDATE";
                    break;
                case 11:
                    $items[$key]['type'] = "Log Report Generation";
                    break;
                default:
                    $items[$key]['type'] = "CUSTOM EDM";
                    break;
            }

            $sender = '';
            $sender_email = '';
            $recipient =  '';
            $recipient_email =  '';

            /*
                edm_id
                id  name
                1 Message Send
                2 Message Received
                3 Redemption
                4 Welcome
                5 Message Send Token
                6 Message Received Token
                7 Monthly Summary
                8 Tier Promotion
                9 Universal //EMAIL BLAST

            */
            switch ($item['type_id']) {
                case 1:
                    if (isset($item->data->subject)) {
                        $edmsubject = $item->data->subject;
                    } else {
                        $edmsubject = 'A little appreciation goes a long way! Your encouragement is sure to make someone’s day.';
                    }
                    $sender =  $item->data->user->name;
                    $sender_email = $item->data->user->email;
                    $recipient = $item->data->recipient->name;
                    $recipient_email =  $item->data->recipient->email;
                    //1 Message Send
                    break;
                case 2:
                    // $sender =  $item->data->user->name;
                    if (isset($item->data->subject)) {
                        $edmsubject = $item->data->subject;
                    } else {
                        $edmsubject = 'Excellent work! `Name` has awarded you with a new badge!';
                    }
                    $sender = "System";
                    $sender_email = config('mail.from.address');
                    $recipient = $item->data->sender->name;
                    $recipient_email =  $item->data->sender->email;
                    //2 Message Received
                    break;
                case 3:
                    if (isset($item->data->subject)) {
                        $edmsubject = $item->data->subject;
                    } else {
                        $edmsubject = 'Your redemption item(s) is/are ready for collection!';
                    }
                    $sender = "System";
                    $sender_email = config('mail.from.address');
                    $recipient =  $item->data->user->name;
                    $recipient_email =  $item->data->user->email;
                    // 3 Redemption
                    break;
                case 4:
                    // 4 Welcome
                    if (isset($item->data->subject)) {
                        $edmsubject = $item->data->subject;
                    } else {
                        $edmsubject = 'Introducing ACE! A platform specially designed for us to appreciate each other better';
                    }
                    $sender = "System";
                    $sender_email = config('mail.from.address');
                    $recipient =  $item->data->user->name;
                    $recipient_email =  $item->data->user->email;
                    break;
                case 5:
                    if (isset($item->data->subject)) {
                        $edmsubject = $item->data->subject;
                    } else {
                        $edmsubject = ' A little appreciation goes a long way! Your encouragement is sure to make someone’ day.';
                    }
                    $sender =  $item->data->user->name;
                    $sender_email = $item->data->user->email;
                    $recipient = $item->data->recipient->name;
                    $recipient_email =  $item->data->recipient->email;
                    // 5 Message Send Token
                    break;
                case 6:
                    if (isset($item->data->subject)) {
                        $edmsubject = $item->data->subject;
                    } else {
                        $edmsubject = 'Excellent work! `Name` has awarded you with a new badge!';
                    }
                    $sender = "System";
                    $sender_email = config('mail.from.address');
                    $recipient = $item->data->sender->name;
                    $recipient_email =  $item->data->sender->email;
                    // 6 Message Received Token
                    break;
                case 7:
                    // Monthly Summary
                     if (isset($item->data->subject)) {
                         $edmsubject = $item->data->subject;
                     } else {
                         $edmsubject = 'Your ACE portal activity summary for the month of `Month` is ready for viewing!';
                     }
                    $sender ="SYSTEM";
                    $sender_email = config('mail.from.address');
                    $recipient =  $item->data->user->name;
                    $recipient_email =  $item->data->user->email;
                    break;
                case 8:
                    // 8 Tier Promotion
                    $sender ="System";
                    $edmsubject =  '';
                    if (isset($item->data->subject)) {
                        $edmsubject = $item->data->subject;
                    } else {
                        $edmsubject = '';
                    }
                    $sender_email = config('mail.from.address');
                    $recipient =  $item->data->user->name;
                    $recipient_email =  $item->data->user->email;
                    break;
                case 9:
                    $sender = "System";
                    $edmsubject =  '';
                    if (isset($item->data->subject)) {
                        $edmsubject = $item->data->subject;
                    } else {
                        $edmsubject = '';
                    }
                    $sender_email = config('mail.from.address');
                    $recipient = $item->data->user->name;
                    $recipient_email =  $item->data->user->email;
                    break;
                case 10:
                    $sender = "System";
                    if (isset($item->data->subject)) {
                        $edmsubject = $item->data->subject;
                    } else {
                        $edmsubject = '';
                    }
                    $sender_email = config('mail.from.address');
                    $recipient = $item->data->user->name;
                    $recipient_email =  $item->data->user->email;
                    break;
                case 11:
                    $sender = "System";
                    if (isset($item->data->subject)) {
                        $edmsubject = $item->data->subject;
                    } else {
                        $edmsubject = '';
                    }
                    $sender_email = config('mail.from.address');
                    if (isset($item->data->user->name)) {
                        $recipient = $item->data->user->name;
                    } else {
                        $recipient = '';
                    }
                    if (isset($item->data->user->email)) {
                        $recipient_email =  $item->data->user->email;
                    } else {
                        $recipient_email ='';
                    }
                    break;
                default:
                    $sender = "System";
                    if (isset($item->data->subject)) {
                        $edmsubject = $item->data->subject;
                    } else {
                        $edmsubject = '';
                    }
                    $sender_email = config('mail.from.address');
                    if (isset($item->data->user->name)) {
                        $recipient = $item->data->user->name;
                    } else {
                        $recipient = '';
                    }
                    if (isset($item->data->user->email)) {
                        $recipient_email =  $item->data->user->email;
                    } else {
                        $recipient_email = '';
                    }
                    break;
            }
            $items[$key]['edm_subject'] = $edmsubject;
            $items[$key]['sender_email'] = $sender_email;
            $items[$key]['sender'] = $sender;
            $items[$key]['recipient'] = $recipient;
            $items[$key]['recipient_email'] = $recipient_email;
        }
        return $items;
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
        $sheet->setCellValue('A1', 'Sender Name');
        $sheet->setCellValue('B1', 'Sender Email');
        $sheet->setCellValue('C1', 'Recipient Name');
        $sheet->setCellValue('D1', 'Recipient E-mail');
        $sheet->setCellValue('E1', 'EDM Subject');
        $sheet->setCellValue('F1', 'Edm Type');
        $sheet->setCellValue('G1', 'Send Date');
        // $sheet->setCellValue('E1', '');
        // $sheet->setCellValue('F1', '');
        // $sheet->setCellValue('G1', '');
    }

    public function setSpreadsheetRow($sheet, $row, $data)
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->toDateString();
        $time = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('H:i:s');
        $sheet->setCellValue("A$row", $data->sender);
        $sheet->setCellValue("B$row", $data->sender_email);
        $sheet->setCellValue("C$row", $data->recipient);
        $sheet->setCellValue("D$row", $data->recipient_email);
        $sheet->setCellValue("E$row", $data->edm_subject);
        $sheet->setCellValue("F$row", $data->type);
        $sheet->setCellValue("G$row", $data->created_at);
        // $sheet->setCellValue("E$row", '');
        // $sheet->setCellValue("F$row", '');
        // $sheet->setCellValue("G$row", '');
    }

    public function setSpreadsheetFilename()
    {
        $dt = date('YMD_His');

        $result = "admin_logs_$dt.xlsx";

        return $result;
    }

    public function masstokenupdate($edm_id, CsvImportRequest $request)
    {
        $data_url["domain"] = $_SERVER['SERVER_NAME'];
        $path = $request->file('csv_masstokenupload')->getRealPath();

        $filenameWithExt = $request->file('csv_masstokenupload')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('csv_masstokenupload')->getClientOriginalExtension();

        $FileNameToStore = $filename.'_'.time().".".$extension;

        $data = array_map('str_getcsv', file($path));

        array_shift($data); // remove header
        //Email ,RO Deduct, RO Add, MR Deduct,  MR Add, Message,    Admin Log Message,  Send EDM

        $RESERVED_EDMS = 9;
        $existing = 0;
        $missing = 0;
        $inactive_user = 0;
        $emailcolumns = [];

        $admin = $request->user();

        /* variable container  */
        $email = '';
        $black_token = 0;

        $blacktoken_deduct = 0;
        $blacktoken_add = 0;

        $greentoken_deduct = 0;
        $greentoken_add = 0;
        $edm_message_email = "";
        $edm_adminlog_message = "";
        $sendemail = "";


        $black_token = 0;
        $green_token = 0;

        $processed = false;
        $error = false;
        $row = 0;

        if ($data) {
            foreach ($data as $key => $value) {
                $row = $row + 1 ;

                if (isset($value[0])) {
                    $email = $value[0];
                } else {
                    $email = '';
                }
                if (isset($value[1])) {
                    $blacktoken_deduct = $value[1];
                } else {
                    $blacktoken_deduct = 0;
                }

                if (isset($value[2])) {
                    $blacktoken_add = $value[2];
                } else {
                    $blacktoken_add = 0;
                }

                if (isset($value[3])) {
                    $greentoken_deduct = $value[3];
                } else {
                    $greentoken_deduct = 0;
                }

                if (isset($value[4])) {
                    $greentoken_add = $value[4];
                } else {
                    $greentoken_add = 0;
                }

                if (isset($value[5])) {
                    $edm_message_email = $value[5];
                } else {
                    $edm_message_email = '';
                }

                if (isset($value[6])) {
                    $edm_adminlog_message = $value[6];
                } else {
                    $edm_adminlog_message = '';
                }
                if (isset($value[7])) {
                    $sendemail = strtolower($value[7]);
                // $sendemail= $value[7];
                } else {
                    $sendemail = '';
                }

                // $sendemail = strtolower($value[7]);

                if (!is_numeric($value[1])) {
                    $error = true;
                    $errormsg = 'Invalid interger value for black token deduct.'.' In row '.$row .' column 2';

                    break;
                } elseif ($value[1] != floor($value[1])) {
                    $error = true;
                    $errormsg = 'Invalid interger value for black token deduct.'.'In row '.$row .' column 2';
                }

                if (!is_numeric($value[2])) {
                    $error = true;
                    $errormsg = 'Invalid interger value for black token add.'.'In row '.$row .' column 3';
                    break;
                } elseif ($value[2] != floor($value[2])) {
                    $error = true;
                    $errormsg = 'Invalid interger value for black token add.'.'In row '.$row .' column 3';
                }

                if (!is_numeric($value[3])) {
                    $error = true;
                    $errormsg = 'Invalid interger value for green token deduct.'.'In row '.$row .' column 4';
                    break;
                } elseif ($value[3] != floor($value[3])) {
                    $error = true;
                    $errormsg = 'Invalid interger value for green token deduct.'.'In row '.$row .' column 4';
                }

                if (!is_numeric($value[4])) {
                    $error = true;
                    $errormsg = 'Invalid interger value for green token add.'.'In row '.$row .' column 5';
                    break;
                } elseif ($value[4] != floor($value[4])) {
                    $error = true;
                    $errormsg = 'Invalid interger value for green token add.'.'In row '.$row .' column 5';
                }
                /* format fields start */

                if ($blacktoken_deduct == '') {
                    $blacktoken_deduct = 0;
                }

                if ($blacktoken_add == '') {
                    $blacktoken_add = 0;
                }

                if ($greentoken_deduct == '') {
                    $greentoken_deduct = 0;
                }

                if ($greentoken_add == '') {
                    $greentoken_add = 0;
                }

                /* format fields end */

                $user = User::where('email', trim($email))->first();

                if ($user) {
                    if ($user->is_active) {
                        array_push($emailcolumns, $value[0]);
                    } else {
                        $inactive_user = $inactive_user + 1;
                    }

                    $existing = $existing + 1;
                } else {
                    $missing = $missing + 1;
                }
            }

            if ($error) {
                return ApiResponse::error(400, [
                    'success' => 0,
                    'errormsg' => $errormsg
                ]);
            }
        }

        $email_recurrence_count = array_count_values($emailcolumns);

        $duplicated = array_filter($email_recurrence_count, function ($value) {
            return $value > 1;
        });

        $duplicate_email_count = count($duplicated);

        // if($duplicate_email_count > 0 ){

        //     return ApiResponse::error(400,[
        //         'success' => 0,
        //         'errormsg' => 'Email is duplicated'
        //     ]);

        // }


        if ($data) {
            foreach ($data as $key => $value) {
                $row = $row + 1 ;
                if (isset($value[0])) {
                    $email = $value[0];
                } else {
                    $email = '';
                }
                if (isset($value[1])) {
                    $blacktoken_deduct = $value[1];
                } else {
                    $blacktoken_deduct = 0;
                }

                if (isset($value[2])) {
                    $blacktoken_add = $value[2];
                } else {
                    $blacktoken_add = 0;
                }

                if (isset($value[3])) {
                    $greentoken_deduct = $value[3];
                } else {
                    $greentoken_deduct = 0;
                }

                if (isset($value[4])) {
                    $greentoken_add = $value[4];
                } else {
                    $greentoken_add = 0;
                }

                if (isset($value[5])) {
                    $edm_message_email = $value[5];
                } else {
                    $edm_message_email = '';
                }

                if (isset($value[6])) {
                    $edm_adminlog_message = $value[6];
                } else {
                    $edm_adminlog_message = '';
                }

                if (isset($value[7])) {
                    $sendemail = strtolower($value[7]);
                } else {
                    $sendemail = '';
                }

                /* format fields end */

                $user = User::where('email', trim($email))->first();

                if ($user) {
                    if ($user->is_active) {
                        array_push($emailcolumns, $value[0]);

                        $processed = true;

                        if ($user->black_token) {
                            if ($user->black_token == '') {
                                $black_token = 0;
                            } else {
                                $black_token = $user->black_token;
                            }
                        } else {
                            $black_token = 0;
                        }

                        $black_token = $black_token - $blacktoken_deduct + $blacktoken_add;
                        if ($black_token < 0) {
                            $black_token = 0;
                        }

                        if ($user->green_token) {
                            if ($user->green_token == '') {
                                $green_token = 0;
                            } else {
                                $green_token = $user->green_token;
                            }
                        } else {
                            $green_token = 0;
                        }

                        $green_token = $green_token - $greentoken_deduct + $greentoken_add;

                        if ($green_token < 0) {
                            $green_token = 0;
                        }


                        $user_id = $user->id;
                        $users_table = User::find($user_id);
                        $users_table->black_token = $black_token;
                        $users_table->green_token = $green_token;
                        $users_table->save();


                        if ($edm_adminlog_message == "") {
                            $edm_adminlog_message = "No admin log message set";
                        }

                        //admin log
                        event(new AdminLogEvent($admin->id, AdminLog::TYPE_EDM_MASSTOKENUPLOAD, [
                              'admin' => $admin->name,
                              'user_id' => $user->id,
                              'user_name' => $user->name,
                              'user_email' => $user->email,
                              'message' =>  $edm_adminlog_message,
                              'csv_file' => $FileNameToStore   //filename of the csv uploaded
                        ]));


                        // $edm_message_email = str_replace('\n',"<br/>",strval($edm_message_email));



                        $edm_message_email = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"), "<br/>", $edm_message_email);

                        if ($sendemail == 'yes') {

                            // send email here

                            $content = $this->generatemasstokenupdatePreview(
                                $user->id,
                                $user->email,
                                false,
                                $edm_id,
                                $admin,
                                $message = $edm_message_email,
                                $RO_deduct = $blacktoken_deduct,
                                $RO_add = $blacktoken_add,
                                $MR_deduct = $greentoken_deduct,
                                $MR_add = $greentoken_add,
                                false,
                                $content=null

                            );

                            try {
                                switch ($data_url["domain"]) {
                                    case 'deloitte-backend.local.nmgdev.com':

                                        break;
                                    default:
                                         Mail::to($user->email)->send($content);

                                }
                            } catch (Exception $e) {
                            }
                        }
                    } else {
                        $inactive_user = $inactive_user + 1;
                    }

                    $existing = $existing + 1;
                } else {
                    $missing = $missing + 1;
                }
            }
        }

        if ($processed == true) {
            $request->file('csv_masstokenupload')->storeAs('public/csv_masstokenupload', $FileNameToStore);

            $data_url["domain"] = $_SERVER['SERVER_NAME'];

            switch ($data_url["domain"]) {
                case 'deloitte-backend.local.nmgdev.com':
                    $FileNameToStore = 'storage/csv_masstokenupload/'.$FileNameToStore;
                    break;
                default:
                    $FileNameToStore  = 'storage/csv_masstokenupload/'.$FileNameToStore;

            }

            $EdmCsvMassUpload = new EdmCsvMassUpload;
            $EdmCsvMassUpload->user_id =  $admin->id;
            $EdmCsvMassUpload->name =   $admin->name;
            $EdmCsvMassUpload->path =  $FileNameToStore;
            $EdmCsvMassUpload->save();
        }


        $emails = array_unique($emailcolumns);


        $unique_email_count = count($emails);


        return ApiResponse::success([
            'sender' =>$admin,
            'data'=> $data,

            'email' =>$emailcolumns,
            'success' => 1,
            'existing' => $existing,
            'missing' => $missing,
            'unique_email_count' => $unique_email_count,
            'duplicate_email_count' => $duplicate_email_count,
            'inactive_user' => $inactive_user,
            'domain' => $data_url["domain"],

        ]);
    }

    public function sendmonthlyedm($edm_id, Request $request)
    {
        $user = User::find(5);
        $isPreview = false;

        $data_url["domain"] = $_SERVER['SERVER_NAME'];

        switch ($data_url["domain"]) {
            case 'deloitte-backend.local.nmgdev.com':

                break;
            default:
                  Mail::to($request->email)->send(new MonthlySummaryMail($user, $isPreview));

        }



        return ApiResponse::success([
           'user' => $user,
           'request_email' => $request->email,
           'success' => 1,


        ]);
    }
}
