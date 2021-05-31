<?php

namespace App\Http\Controllers\Admin;

use App\Events\AdminLogEvent;
use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\BlackTokenLog;
use App\Models\GreenTokenLog;
use App\Models\LogDownloads;

use App\Mail\AdminLogMail;

use App\Repositories\AdminLogRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

class LogController extends Controller
{
    public function index(Request $request, AdminLogRepository $adminLogRepo)
    {
        $query = $this->prepareQuery($request, $adminLogRepo);
        $result = $adminLogRepo->pager($query);
        $result = $this->addRemarksField($result);
        $result = $this->adminLogType($result);
        if ($result instanceof \Exception) {
            return ApiResponse::exception(ApiException::serverError($result->getMessage()));
        }
        return ApiResponse::success($result);
    }

    public function getDownloadableLogs(Request $request)
    {
        $logDownloads = new LogDownloads();
        $result = $logDownloads->pager($logDownloads);
        if ($result instanceof \Exception) {
            return ApiResponse::exception(ApiException::serverError($result->getMessage()));
        }
        return ApiResponse::success($result);
    }

    public function downloadLog(Request $request)
    {
        if ($request->has('id')) {
            $id = $request->input('id');
            $log = LogDownloads::find($id);
            if (!$log->id) {
                return ApiResponse::error(400, ['error' => 'ID invalid']);
            } else {
                $savePath = storage_path("app/reports/$log->filename");
            }
        }
        $type = explode('_', $log->filename);
        event(new AdminLogEvent($request->user()->id, AdminLog::TYPE_ADMIN_DOWNLOAD_X_RECORD, [
            'admin' => $request->user()->name,
            'type' => $log->type,
        ]));
        return response()->download($savePath, $log->filename, [
            'Content-Type' => 'text/csv',
            'Cache-Control' => 'no-cache, must-revalidate'
        ]);//
    }

    public function generateCsv(Request $request, AdminLogRepository $adminLogRepo)
    {
        ob_end_clean();
        ignore_user_abort(true); // just to be safe
        ob_start();
        $result['success'] = true;
        // $response = ApiResponse::success($result);

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

        $query = $this->prepareQuery($request, $adminLogRepo);
        $type = '';
        if ($request->filled('type')) {
            $types = ['', 'Banner','EDM','Inventory','User','Reports','CMS','Systemlogs','Mass Token Update','Growth Achievement',];
            $type = $types[$request->input('type')];
        }

        $request->request->add(['paginate' => 0]);
        $dateGenerated = date("Y-m-d-H-i-s");
        $filename = "data_export_" . $dateGenerated . "_" . $type . ".csv";
        $logDownload = new LogDownloads();
        $logDownload->filename = $filename;
        $logDownload->status = 'generating';
        $logDownload->type = 'Administrator Activity Log';
        $logDownload->save();
        $now = gmdate("D, d M Y H:i:s");
        $savePath = storage_path("app/reports/$filename");
        $df = fopen($savePath, 'w');
        fputcsv($df, [
            'NAME',
            'DATE',
            'TIME',
            'DESCRIPTION',
            'REMARKS',
            'ACTIVITY TYPE',
            'COUNTRY',
        ]);
        $request->merge(['paginate' => 1]);
        $rpp = 2000;
        $request->merge(['rpp' => 1]);
        $result = $adminLogRepo->pager($query);
        $total = $result->total();
        $perPage = $rpp;
        $request->merge(['rpp' => 2000]);
        for ($page = 0; $page <= $total; $page = $page + $perPage) {
            $pageVal = intval($total / ($page + $perPage)) + 1;
            $request->merge(['page' => $pageVal]);
            $result = $adminLogRepo->pager($query);

            foreach ($result as $key => $data) {
                $data = $this->addRemarksFieldSolo($data);
                $data = $this->set_activity_type($data);
                $created_at = strtotime($data->created_at);
                $datetime = explode(' ', $data->created_at);
                $row = [
                    $data->user->name,
                    $datetime[0],
                    $datetime[1],
                    $data->description,
                    $data->remarks,
                    $data->activity_type,
                    $this->countryCodeToCountry($data->user->country)
                ];
                fputcsv($df, $row);
            }
        }
        fclose($df);
        $logDownload->status = 'ready';
        $logDownload->save();

        $admin = $request->user();

        // Mail::raw('Log generated at ' . $logDownload->created_at . ' is ready.', function ($message) use ($admin) {
        //     $message->to($admin->email)
        //         ->subject('Activity log generation complete');
        // });

        $user = $request->user();
        Mail::to($admin->email)->send(new AdminLogMail($user, $message = 'Log generated at ' . $logDownload->created_at . ' is ready.', $subject ='Activity log generation complete',$isPreview=false));

    }

    private function prepareQuery(Request $request, AdminLogRepository $adminLogRepo)
    {
        $query = $adminLogRepo;
        $type = 'All';
        if ($request->filled('type')) {
            switch ($request->input('type')) {
                case 1:
                    $type = 'Banner';
                    $query = $query->whereIn('type', [
                        AdminLog::TYPE_BANNER_CREATE,
                        AdminLog::TYPE_BANNER_DELETE,
                        AdminLog::TYPE_BANNER_UPDATE,
                    ]);
                    break;
                case 2:
                    $type = 'EDM';
                    $query = $query->whereIn('type', [
                        AdminLog::TYPE_EDM_UPDATE,
                        AdminLog::TYPE_EDM_FOOTER_EDIT,
                        AdminLog::TYPE_EDM_HEADER_EDIT,
                        AdminLog::TYPE_EDM_TEMPLATE_BODY,
                        // AdminLog::TYPE_EDM_SENT_EMAIL,
                        // AdminLog::TYPE_EDM_RECEIVE_EMAIL,
                        // AdminLog::TYPE_EDM_WELCOME_EMAIL,
                        // AdminLog::TYPE_EDM_REDEMPTION_EMAIL,
                        // AdminLog::TYPE_EDM_MONTHLYREPORT_EMAIL,
                        AdminLog::TYPE_EDM_TIERPROMOTION_EMAIL,
                        AdminLog::TYPE_EDM_TEMPLATE_BODY_CREATE,
                        AdminLog::TYPE_EDM_TEMPLATE_BODY_DELETE,
                        AdminLog::TYPE_EDM_SENTLOGS_DOWNLOAD,
                        AdminLog::TYPE_ADMINLOG_EMAIL,

                    ]);
                    break;
                case 3:
                    $type = 'Inventory';
                    $query = $query->whereIn('type', [
                        AdminLog::TYPE_REWARDS_CREATE,
                        AdminLog::TYPE_REWARDS_CREDIT,
                        AdminLog::TYPE_REWARDS_DEBIT,
                        AdminLog::TYPE_REWARDS_UPDATE,
                    ]);
                    break;
                case 4:
                    $type = 'User';
                    $query = $query->whereIn('type', [
                        AdminLog::TYPE_USER_BLOCK,
                        AdminLog::TYPE_USER_TOKEN,
                        AdminLog::TYPE_USER_TOKEN_TRANSFER,
                        AdminLog::TYPE_USER_TOKEN_DEDUCT,
                        AdminLog::TYPE_USER_TOKEN_TRANSFER_RECOGNIZE,
                        AdminLog::TYPE_USER_TOKEN_DEDUCT_RECOGNIZE,
                        AdminLog::TYPE_USER_UPDATE,
                        AdminLog::TYPE_ADMIN_ACCESS_GRANTED,
                        AdminLog::TYPE_ADMIN_ACCESS_REVOKED,
                        AdminLog::TYPE_PORTAL_ACCESS_GRANTED,
                        AdminLog::TYPE_PORTAL_ACCESS_REVOKED,
                    ]);
                    break;
                case 5:
                    $type = 'Reports';
                    $query = $query->whereIn('type', [
                        AdminLog::TYPE_DOWNLOAD_LOG,
                        AdminLog::TYPE_ADMIN_DOWNLOAD_RECORD,
                        AdminLog::TYPE_ADMIN_DOWNLOAD_X_RECORD,
                    ]);
                    break;
                case 6:
                    $type = 'CMS';
                    $query = $query->whereIn('type', [
                        AdminLog::TYPE_CMS_FAQ_EDIT,
                        AdminLog::TYPE_CMS_FAQ_ADD,
                        AdminLog::TYPE_CMS_FAQ_SORT,
                        AdminLog::TYPE_CMS_FAQ_DELETE,
                        AdminLog::TYPE_CMS_FAQ_DELETEDMANYOPTION,

                        AdminLog::TYPE_CMS_FAQ_CATEGORY_EDIT,
                        AdminLog::TYPE_CMS_FAQ_CATEGORY_ADD,
                        AdminLog::TYPE_CMS_FAQ_CATEGORY_SORT,
                        AdminLog::TYPE_CMS_FAQ_CATEGORY_DELETE,
                        AdminLog::TYPE_CMS_FAQ_CATEGORY_DELETEDMANYOPTION,

                        AdminLog::TYPE_CMS_FAQ_UPLOAD,

                        AdminLog::TYPE_CMS_PAGE_EDIT,
                        AdminLog::TYPE_CMS_PAGE_ADD,
                        AdminLog::TYPE_CMS_PAGE_SORT,
                        AdminLog::TYPE_CMS_PAGE_DELETE,
                        AdminLog::TYPE_CMS_PAGE_DELETEDMANYOPTION,
                    ]);
                    break;

                case 7:
                     $type = 'Systemlogs';
                     $query = $query->whereIn('type', [
                        AdminLog::TYPE_POSTMESSAGE_AND_SENDTOKEN,
                        AdminLog::TYPE_REMOVERETAIN_REMOVE_BADGES,
                        AdminLog::TYPE_REMOVERETAIN_RETAIN_BADGES,
                        AdminLog::TYPE_REMOVERETAIN_REMOVE_TOKEN,
                        AdminLog::TYPE_REMOVERETAIN_RETAIN_TOKEN,
                        AdminLog::TYPE_POST_REFUND_TOKEN,
                        AdminLog::TYPE_UPDATE_TIER,
                        AdminLog::TYPE_PROMOTION_REWARDSTOKEN,
                        AdminLog::TYPE_BADGE_REWARDSTOKEN,
                        AdminLog::TYPE_EDM_MASSTOKENUPLOAD,
                        AdminLog::TYPE_DELETE_MESSAGES,
                        AdminLog::TYPE_DELETE_BADGE,


                        ]);
                     break;
                case 8:
                     $type = 'Mass Token Update';
                     $query = $query->whereIn('type', [
                            AdminLog::TYPE_EDM_MASSTOKENUPLOAD,
                        ]);
                     break;
                case 9:
                     $type = 'Growth Achievement';
                     $query = $query->whereIn('type', [
                        AdminLog::TYPE_POSTMESSAGE_AND_SENDTOKEN,
                        AdminLog::TYPE_REMOVERETAIN_REMOVE_BADGES,
                        AdminLog::TYPE_REMOVERETAIN_RETAIN_BADGES,
                        AdminLog::TYPE_REMOVERETAIN_REMOVE_TOKEN,
                        AdminLog::TYPE_REMOVERETAIN_RETAIN_TOKEN,

                        AdminLog::TYPE_POST_REFUND_TOKEN,
                        AdminLog::TYPE_UPDATE_TIER,
                        AdminLog::TYPE_PROMOTION_REWARDSTOKEN,
                        AdminLog::TYPE_BADGE_REWARDSTOKEN,
                        AdminLog::TYPE_DELETE_MESSAGES,

                        AdminLog::TYPE_DELETE_BADGE,


                        ]);
                     break;
                default:
            }
        }

        if ($request->filled('from')) {
            $from = Carbon::createFromFormat('Y-m-d', $request->input('from'));
            $from->hour = 0;
            $from->minute = 0;
            $from->second = 0;
            $query = $query->where("{$adminLogRepo->getTable()}.created_at", '>=', $from->toDateTimeString());
        }

        if ($request->filled('to')) {
            $to = Carbon::createFromFormat('Y-m-d', $request->input('to'));
            $to->hour = 23;
            $to->minute = 59;
            $to->second = 59;
            $query = $query->where("{$adminLogRepo->getTable()}.created_at", '<=', $to->toDateTimeString());
        }
        return $query;
    }

    private function addRemarksAndLogType($data)
    {
        $cnt = count($data);
        for ($x = 0; $x < $cnt; $x++) {
            $data[$x] = $this->addRemarksFieldSolo($data[$x]);
            $data[$x] = $this->set_activity_type($data[$x]);
        }
        return $data;
    }

    private function addRemarksFieldSolo($log)
    {
        $gtoken = [];
        if ($log['type'] === AdminLog::TYPE_USER_TOKEN_TRANSFER_RECOGNIZE || $log['type'] === AdminLog::TYPE_USER_TOKEN_DEDUCT_RECOGNIZE) {
            $gtoken = BlackTokenLog::whereNotNull('remarks')->where('created_at', $log['created_at'])->get(['remarks']);
        } elseif ($log['type'] == AdminLog::TYPE_USER_TOKEN_TRANSFER && $log['type'] == AdminLog::TYPE_USER_TOKEN_DEDUCT) {
            $gtoken = GreenTokenLog::whereNotNull('remarks')->where('created_at', $log['created_at'])->get(['remarks']);
        }
        foreach ($gtoken as $fields) {
            $log['remarks'] = $fields['remarks'];
        }
        return $log;
    }

    public function addRemarksField($data)
    {
        $cnt = count($data);
        for ($x = 0; $x < $cnt; $x++) {
            $gtoken = [];
            if ($data[$x]['type'] === AdminLog::TYPE_USER_TOKEN_TRANSFER_RECOGNIZE || $data[$x]['type'] === AdminLog::TYPE_USER_TOKEN_DEDUCT_RECOGNIZE) {
                $gtoken = BlackTokenLog::whereNotNull('remarks')->where('created_at', $data[$x]['created_at'])->get(['remarks']);
            } elseif ($data[$x]['type'] == AdminLog::TYPE_USER_TOKEN_TRANSFER && $data[$x]['type'] == AdminLog::TYPE_USER_TOKEN_DEDUCT) {
                $gtoken = GreenTokenLog::whereNotNull('remarks')->where('created_at', $data[$x]['created_at'])->get(['remarks']);
            }
            foreach ($gtoken as $fields) {
                $data[$x]['remarks'] = $fields['remarks'];
            }
        }
       return $data;
    }

    private function adminLogType($data){
        $cnt = count($data);
        for ($x = 0; $x < $cnt; $x++) {
            $data[$x] = $this->set_activity_type($data[$x]);
        }

        return $data;
    }

    private function set_activity_type($log) {

        $wtype = "ALL";

        $banner = [

            AdminLog::TYPE_BANNER_CREATE,
            AdminLog::TYPE_BANNER_DELETE,
            AdminLog::TYPE_BANNER_UPDATE,
        ];

        $edm = [

            AdminLog::TYPE_EDM_UPDATE,
            AdminLog::TYPE_EDM_FOOTER_EDIT,
            AdminLog::TYPE_EDM_HEADER_EDIT,
            AdminLog::TYPE_EDM_TEMPLATE_BODY,
            // AdminLog::TYPE_EDM_SENT_EMAIL,
            // AdminLog::TYPE_EDM_RECEIVE_EMAIL,
            // AdminLog::TYPE_EDM_WELCOME_EMAIL,
            // AdminLog::TYPE_EDM_REDEMPTION_EMAIL,
            // AdminLog::TYPE_EDM_MONTHLYREPORT_EMAIL,
            AdminLog::TYPE_EDM_TIERPROMOTION_EMAIL,
            AdminLog::TYPE_EDM_TEMPLATE_BODY_CREATE,
            AdminLog::TYPE_EDM_TEMPLATE_BODY_DELETE,
            AdminLog::TYPE_EDM_SENTLOGS_DOWNLOAD,
            AdminLog::TYPE_ADMINLOG_EMAIL,

        ];

        $inventory = [

            AdminLog::TYPE_REWARDS_CREATE,
            AdminLog::TYPE_REWARDS_CREDIT,
            AdminLog::TYPE_REWARDS_DEBIT,
            AdminLog::TYPE_REWARDS_UPDATE,
        ];

        $user = [

            AdminLog::TYPE_USER_BLOCK,
            AdminLog::TYPE_USER_TOKEN,
            AdminLog::TYPE_USER_TOKEN_TRANSFER,
            AdminLog::TYPE_USER_TOKEN_DEDUCT,
            AdminLog::TYPE_USER_TOKEN_TRANSFER_RECOGNIZE,
            AdminLog::TYPE_USER_TOKEN_DEDUCT_RECOGNIZE,
            AdminLog::TYPE_USER_UPDATE,
            AdminLog::TYPE_ADMIN_ACCESS_GRANTED,
            AdminLog::TYPE_ADMIN_ACCESS_REVOKED,
            AdminLog::TYPE_PORTAL_ACCESS_GRANTED,
            AdminLog::TYPE_PORTAL_ACCESS_REVOKED,

        ];

        $reports = [

            AdminLog::TYPE_DOWNLOAD_LOG,
            AdminLog::TYPE_ADMIN_DOWNLOAD_RECORD,
            AdminLog::TYPE_ADMIN_DOWNLOAD_X_RECORD,
        ];

        $cms = [

            AdminLog::TYPE_CMS_FAQ_EDIT,
            AdminLog::TYPE_CMS_FAQ_ADD,
            AdminLog::TYPE_CMS_FAQ_SORT,
            AdminLog::TYPE_CMS_FAQ_DELETE,
            AdminLog::TYPE_CMS_FAQ_DELETEDMANYOPTION,

            AdminLog::TYPE_CMS_FAQ_CATEGORY_EDIT,
            AdminLog::TYPE_CMS_FAQ_CATEGORY_ADD,
            AdminLog::TYPE_CMS_FAQ_CATEGORY_SORT,
            AdminLog::TYPE_CMS_FAQ_CATEGORY_DELETE,
            AdminLog::TYPE_CMS_FAQ_CATEGORY_DELETEDMANYOPTION,

            AdminLog::TYPE_CMS_FAQ_UPLOAD,

            AdminLog::TYPE_CMS_PAGE_EDIT,
            AdminLog::TYPE_CMS_PAGE_ADD,
            AdminLog::TYPE_CMS_PAGE_SORT,
            AdminLog::TYPE_CMS_PAGE_DELETE,
            AdminLog::TYPE_CMS_PAGE_DELETEDMANYOPTION,
        ];

        // $systemlogs = [

        //     AdminLog::TYPE_POSTMESSAGE_AND_SENDTOKEN,
        //     AdminLog::TYPE_REMOVERETAIN_REMOVE_BADGES,
        //     AdminLog::TYPE_REMOVERETAIN_RETAIN_BADGES,
        //     AdminLog::TYPE_REMOVERETAIN_REMOVE_TOKEN,
        //     AdminLog::TYPE_REMOVERETAIN_RETAIN_TOKEN,

        //     AdminLog::TYPE_POST_REFUND_TOKEN,
        //     AdminLog::TYPE_UPDATE_TIER,
        //     AdminLog::TYPE_PROMOTION_REWARDSTOKEN,
        //     AdminLog::TYPE_BADGE_REWARDSTOKEN,
        //     AdminLog::TYPE_EDM_MASSTOKENUPLOAD,

        //     AdminLog::TYPE_DELETE_MESSAGES,
        //     AdminLog::TYPE_DELETE_BADGE,

        // ];


        $MassTokenUpdate = [

            AdminLog::TYPE_EDM_MASSTOKENUPLOAD,

        ];

        $GrowthAchievement = [

            AdminLog::TYPE_POSTMESSAGE_AND_SENDTOKEN,
            AdminLog::TYPE_REMOVERETAIN_REMOVE_BADGES,
            AdminLog::TYPE_REMOVERETAIN_RETAIN_BADGES,
            AdminLog::TYPE_REMOVERETAIN_REMOVE_TOKEN,
            AdminLog::TYPE_REMOVERETAIN_RETAIN_TOKEN,

            AdminLog::TYPE_POST_REFUND_TOKEN,
            AdminLog::TYPE_UPDATE_TIER,
            AdminLog::TYPE_PROMOTION_REWARDSTOKEN,
            AdminLog::TYPE_BADGE_REWARDSTOKEN,
            AdminLog::TYPE_DELETE_MESSAGES,

            AdminLog::TYPE_DELETE_BADGE,

        ];



        if(in_array($log['type'], $banner)){
            $wtype = "Banner";
        }
        else if(in_array($log['type'], $edm)){
            // $wtype = "Inventory";
            $wtype = "EDM";
        }
        else if(in_array($log['type'], $inventory)){
            $wtype = "Inventory";
        }
        else if(in_array($log['type'], $user)){
            $wtype = "User";
        }
        else if(in_array($log['type'], $reports)){
            $wtype = "Reports";
        }
        else if(in_array($log['type'], $cms)){
            $wtype = "CMS";
        }
        // else if(in_array($log['type'], $systemlogs)){
        //     $wtype = "Systemlogs";
        // }
        else if(in_array($log['type'], $MassTokenUpdate)){
            $wtype = "Mass Token Update";
        }
        else if(in_array($log['type'], $GrowthAchievement)){
            $wtype = "Growth Achievement";
        }
        $log['activity_type'] = $wtype;
        return $log;
    }


    public function countryCodeToCountry($code) {

        $code = strtoupper($code);
        if ($code == 'AF') return 'Afghanistan';
        if ($code == 'AX') return 'Aland Islands';
        if ($code == 'AL') return 'Albania';
        if ($code == 'DZ') return 'Algeria';
        if ($code == 'AS') return 'American Samoa';
        if ($code == 'AD') return 'Andorra';
        if ($code == 'AO') return 'Angola';
        if ($code == 'AI') return 'Anguilla';
        if ($code == 'AQ') return 'Antarctica';
        if ($code == 'AG') return 'Antigua and Barbuda';
        if ($code == 'AR') return 'Argentina';
        if ($code == 'AM') return 'Armenia';
        if ($code == 'AW') return 'Aruba';
        if ($code == 'AU') return 'Australia';
        if ($code == 'AT') return 'Austria';
        if ($code == 'AZ') return 'Azerbaijan';
        if ($code == 'BS') return 'Bahamas the';
        if ($code == 'BH') return 'Bahrain';
        if ($code == 'BD') return 'Bangladesh';
        if ($code == 'BB') return 'Barbados';
        if ($code == 'BY') return 'Belarus';
        if ($code == 'BE') return 'Belgium';
        if ($code == 'BZ') return 'Belize';
        if ($code == 'BJ') return 'Benin';
        if ($code == 'BM') return 'Bermuda';
        if ($code == 'BT') return 'Bhutan';
        if ($code == 'BO') return 'Bolivia';
        if ($code == 'BA') return 'Bosnia and Herzegovina';
        if ($code == 'BW') return 'Botswana';
        if ($code == 'BV') return 'Bouvet Island (Bouvetoya)';
        if ($code == 'BR') return 'Brazil';
        if ($code == 'IO') return 'British Indian Ocean Territory (Chagos Archipelago)';
        if ($code == 'VG') return 'British Virgin Islands';
        if ($code == 'BN') return 'Brunei Darussalam';
        if ($code == 'BG') return 'Bulgaria';
        if ($code == 'BF') return 'Burkina Faso';
        if ($code == 'BI') return 'Burundi';
        if ($code == 'KH') return 'Cambodia';
        if ($code == 'CM') return 'Cameroon';
        if ($code == 'CA') return 'Canada';
        if ($code == 'CV') return 'Cape Verde';
        if ($code == 'KY') return 'Cayman Islands';
        if ($code == 'CF') return 'Central African Republic';
        if ($code == 'TD') return 'Chad';
        if ($code == 'CL') return 'Chile';
        if ($code == 'CN') return 'China';
        if ($code == 'CX') return 'Christmas Island';
        if ($code == 'CC') return 'Cocos (Keeling) Islands';
        if ($code == 'CO') return 'Colombia';
        if ($code == 'KM') return 'Comoros the';
        if ($code == 'CD') return 'Congo';
        if ($code == 'CG') return 'Congo the';
        if ($code == 'CK') return 'Cook Islands';
        if ($code == 'CR') return 'Costa Rica';
        if ($code == 'CI') return 'Cote d\'Ivoire';
        if ($code == 'HR') return 'Croatia';
        if ($code == 'CU') return 'Cuba';
        if ($code == 'CY') return 'Cyprus';
        if ($code == 'CZ') return 'Czech Republic';
        if ($code == 'DK') return 'Denmark';
        if ($code == 'DJ') return 'Djibouti';
        if ($code == 'DM') return 'Dominica';
        if ($code == 'DO') return 'Dominican Republic';
        if ($code == 'EC') return 'Ecuador';
        if ($code == 'EG') return 'Egypt';
        if ($code == 'SV') return 'El Salvador';
        if ($code == 'GQ') return 'Equatorial Guinea';
        if ($code == 'ER') return 'Eritrea';
        if ($code == 'EE') return 'Estonia';
        if ($code == 'ET') return 'Ethiopia';
        if ($code == 'FO') return 'Faroe Islands';
        if ($code == 'FK') return 'Falkland Islands (Malvinas)';
        if ($code == 'FJ') return 'Fiji the Fiji Islands';
        if ($code == 'FI') return 'Finland';
        if ($code == 'FR') return 'France, French Republic';
        if ($code == 'GF') return 'French Guiana';
        if ($code == 'PF') return 'French Polynesia';
        if ($code == 'TF') return 'French Southern Territories';
        if ($code == 'GA') return 'Gabon';
        if ($code == 'GM') return 'Gambia the';
        if ($code == 'GE') return 'Georgia';
        if ($code == 'DE') return 'Germany';
        if ($code == 'GH') return 'Ghana';
        if ($code == 'GI') return 'Gibraltar';
        if ($code == 'GR') return 'Greece';
        if ($code == 'GL') return 'Greenland';
        if ($code == 'GD') return 'Grenada';
        if ($code == 'GP') return 'Guadeloupe';
        if ($code == 'GU') return 'Guam';
        if ($code == 'GT') return 'Guatemala';
        if ($code == 'GG') return 'Guernsey';
        if ($code == 'GN') return 'Guinea';
        if ($code == 'GW') return 'Guinea-Bissau';
        if ($code == 'GY') return 'Guyana';
        if ($code == 'HT') return 'Haiti';
        if ($code == 'HM') return 'Heard Island and McDonald Islands';
        if ($code == 'VA') return 'Holy See (Vatican City State)';
        if ($code == 'HN') return 'Honduras';
        if ($code == 'HK') return 'Hong Kong';
        if ($code == 'HU') return 'Hungary';
        if ($code == 'IS') return 'Iceland';
        if ($code == 'IN') return 'India';
        if ($code == 'ID') return 'Indonesia';
        if ($code == 'IR') return 'Iran';
        if ($code == 'IQ') return 'Iraq';
        if ($code == 'IE') return 'Ireland';
        if ($code == 'IM') return 'Isle of Man';
        if ($code == 'IL') return 'Israel';
        if ($code == 'IT') return 'Italy';
        if ($code == 'JM') return 'Jamaica';
        if ($code == 'JP') return 'Japan';
        if ($code == 'JE') return 'Jersey';
        if ($code == 'JO') return 'Jordan';
        if ($code == 'KZ') return 'Kazakhstan';
        if ($code == 'KE') return 'Kenya';
        if ($code == 'KI') return 'Kiribati';
        if ($code == 'KP') return 'Korea';
        if ($code == 'KR') return 'Korea';
        if ($code == 'KW') return 'Kuwait';
        if ($code == 'KG') return 'Kyrgyz Republic';
        if ($code == 'LA') return 'Lao';
        if ($code == 'LV') return 'Latvia';
        if ($code == 'LB') return 'Lebanon';
        if ($code == 'LS') return 'Lesotho';
        if ($code == 'LR') return 'Liberia';
        if ($code == 'LY') return 'Libyan Arab Jamahiriya';
        if ($code == 'LI') return 'Liechtenstein';
        if ($code == 'LT') return 'Lithuania';
        if ($code == 'LU') return 'Luxembourg';
        if ($code == 'MO') return 'Macao';
        if ($code == 'MK') return 'Macedonia';
        if ($code == 'MG') return 'Madagascar';
        if ($code == 'MW') return 'Malawi';
        if ($code == 'MY') return 'Malaysia';
        if ($code == 'MV') return 'Maldives';
        if ($code == 'ML') return 'Mali';
        if ($code == 'MT') return 'Malta';
        if ($code == 'MH') return 'Marshall Islands';
        if ($code == 'MQ') return 'Martinique';
        if ($code == 'MR') return 'Mauritania';
        if ($code == 'MU') return 'Mauritius';
        if ($code == 'YT') return 'Mayotte';
        if ($code == 'MX') return 'Mexico';
        if ($code == 'FM') return 'Micronesia';
        if ($code == 'MD') return 'Moldova';
        if ($code == 'MC') return 'Monaco';
        if ($code == 'MN') return 'Mongolia';
        if ($code == 'ME') return 'Montenegro';
        if ($code == 'MS') return 'Montserrat';
        if ($code == 'MA') return 'Morocco';
        if ($code == 'MZ') return 'Mozambique';
        if ($code == 'MM') return 'Myanmar';
        if ($code == 'NA') return 'Namibia';
        if ($code == 'NR') return 'Nauru';
        if ($code == 'NP') return 'Nepal';
        if ($code == 'AN') return 'Netherlands Antilles';
        if ($code == 'NL') return 'Netherlands the';
        if ($code == 'NC') return 'New Caledonia';
        if ($code == 'NZ') return 'New Zealand';
        if ($code == 'NI') return 'Nicaragua';
        if ($code == 'NE') return 'Niger';
        if ($code == 'NG') return 'Nigeria';
        if ($code == 'NU') return 'Niue';
        if ($code == 'NF') return 'Norfolk Island';
        if ($code == 'MP') return 'Northern Mariana Islands';
        if ($code == 'NO') return 'Norway';
        if ($code == 'OM') return 'Oman';
        if ($code == 'PK') return 'Pakistan';
        if ($code == 'PW') return 'Palau';
        if ($code == 'PS') return 'Palestinian Territory';
        if ($code == 'PA') return 'Panama';
        if ($code == 'PG') return 'Papua New Guinea';
        if ($code == 'PY') return 'Paraguay';
        if ($code == 'PE') return 'Peru';
        if ($code == 'PH') return 'Philippines';
        if ($code == 'PN') return 'Pitcairn Islands';
        if ($code == 'PL') return 'Poland';
        if ($code == 'PT') return 'Portugal, Portuguese Republic';
        if ($code == 'PR') return 'Puerto Rico';
        if ($code == 'QA') return 'Qatar';
        if ($code == 'RE') return 'Reunion';
        if ($code == 'RO') return 'Romania';
        if ($code == 'RU') return 'Russian Federation';
        if ($code == 'RW') return 'Rwanda';
        if ($code == 'BL') return 'Saint Barthelemy';
        if ($code == 'SH') return 'Saint Helena';
        if ($code == 'KN') return 'Saint Kitts and Nevis';
        if ($code == 'LC') return 'Saint Lucia';
        if ($code == 'MF') return 'Saint Martin';
        if ($code == 'PM') return 'Saint Pierre and Miquelon';
        if ($code == 'VC') return 'Saint Vincent and the Grenadines';
        if ($code == 'WS') return 'Samoa';
        if ($code == 'SM') return 'San Marino';
        if ($code == 'ST') return 'Sao Tome and Principe';
        if ($code == 'SA') return 'Saudi Arabia';
        if ($code == 'SN') return 'Senegal';
        if ($code == 'RS') return 'Serbia';
        if ($code == 'SC') return 'Seychelles';
        if ($code == 'SL') return 'Sierra Leone';
        if ($code == 'SG') return 'Singapore';
        if ($code == 'SK') return 'Slovakia (Slovak Republic)';
        if ($code == 'SI') return 'Slovenia';
        if ($code == 'SB') return 'Solomon Islands';
        if ($code == 'SO') return 'Somalia, Somali Republic';
        if ($code == 'ZA') return 'South Africa';
        if ($code == 'GS') return 'South Georgia and the South Sandwich Islands';
        if ($code == 'ES') return 'Spain';
        if ($code == 'LK') return 'Sri Lanka';
        if ($code == 'SD') return 'Sudan';
        if ($code == 'SR') return 'Suriname';
        if ($code == 'SJ') return 'Svalbard & Jan Mayen Islands';
        if ($code == 'SZ') return 'Swaziland';
        if ($code == 'SE') return 'Sweden';
        if ($code == 'CH') return 'Switzerland, Swiss Confederation';
        if ($code == 'SY') return 'Syrian Arab Republic';
        if ($code == 'TW') return 'Taiwan';
        if ($code == 'TJ') return 'Tajikistan';
        if ($code == 'TZ') return 'Tanzania';
        if ($code == 'TH') return 'Thailand';
        if ($code == 'TL') return 'Timor-Leste';
        if ($code == 'TG') return 'Togo';
        if ($code == 'TK') return 'Tokelau';
        if ($code == 'TO') return 'Tonga';
        if ($code == 'TT') return 'Trinidad and Tobago';
        if ($code == 'TN') return 'Tunisia';
        if ($code == 'TR') return 'Turkey';
        if ($code == 'TM') return 'Turkmenistan';
        if ($code == 'TC') return 'Turks and Caicos Islands';
        if ($code == 'TV') return 'Tuvalu';
        if ($code == 'UG') return 'Uganda';
        if ($code == 'UA') return 'Ukraine';
        if ($code == 'AE') return 'United Arab Emirates';
        if ($code == 'GB') return 'United Kingdom';
        if ($code == 'US') return 'United States of America';
        if ($code == 'UM') return 'United States Minor Outlying Islands';
        if ($code == 'VI') return 'United States Virgin Islands';
        if ($code == 'UY') return 'Uruguay, Eastern Republic of';
        if ($code == 'UZ') return 'Uzbekistan';
        if ($code == 'VU') return 'Vanuatu';
        if ($code == 'VE') return 'Venezuela';
        if ($code == 'VN') return 'Vietnam';
        if ($code == 'WF') return 'Wallis and Futuna';
        if ($code == 'EH') return 'Western Sahara';
        if ($code == 'YE') return 'Yemen';
        if ($code == 'XK') return 'Kosovo';
        if ($code == 'ZM') return 'Zambia';
        if ($code == 'ZW') return 'Zimbabwe';
        return '';
    }

}
