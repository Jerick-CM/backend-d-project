<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminLogMail;
use App\Models\LogDownloads;
use App\Repositories\BlackTokenLogRepository;
use App\Repositories\MessageRepository;
use App\Repositories\RedeemRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

class TransactionsController extends Controller
{
    /**
     * Fetch a list of transactions. It could be:
     *
     * 1. Sent green token
     * 2. Received black token
     * 3. Token spent on redeem
     *
     * @param Request $request
     * @param BlackTokenLogRepository $blackTokenLogRepo
     * @param MessageRepository $messageRepo
     * @param RedeemRepository $redeemRepo
     * @return ApiResponse
     */
    public function index(
        Request $request,
        BlackTokenLogRepository $blackTokenLogRepo,
        MessageRepository $messageRepo,
        RedeemRepository $redeemRepo
    ) {
        switch ($request->input('type')) {
            default:
            case 'sent':
                $type = "User to User Transaction";
                $repo = $messageRepo;
                $query = $repo->withTrashed();
                break;
            case 'received':
                $type = "System to User Transaction";
                $repo = $blackTokenLogRepo;
                $query = $repo->with('user')->where('action', BlackTokenLogRepository::ACTION_CREDIT);
                break;
            case 'spent':
                $type = "Ace E-Store Transaction";
                $repo = $redeemRepo;
                $query = $repo->with('user');
                break;
        }

        if ($request->filled('from')) {
            $from = Carbon::createFromFormat('Y-m-d', $request->input('from'));
            $from->hour = 0;
            $from->minute = 0;
            $from->second = 0;
            $query = $query->where("{$repo->getTable()}.created_at", '>=', $from->toDateTimeString());
        }

        if ($request->filled('to')) {
            $to = Carbon::createFromFormat('Y-m-d', $request->input('to'));
            $to->hour = 23;
            $to->minute = 59;
            $to->second = 59;
            $query = $query->where("{$repo->getTable()}.created_at", '<=', $to->toDateTimeString());
        }

        if ($request->has('download')) {
            $request->request->add(['paginate' => 0]);
            ini_set('max_execution_time', 1800);
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
            $request->request->add(['paginate' => 0]);
            $dateGenerated = date("Y-m-d-H-i-s");
            $filename = "data_export_" . $dateGenerated . ".csv";
            $logDownload = new LogDownloads();
            $logDownload->filename = $filename;
            $logDownload->status = 'generating';
            $logDownload->type = $type;
            $logDownload->save();
            $now = gmdate("D, d M Y H:i:s");
            $savePath = storage_path("app/reports/$filename");
            $df = fopen($savePath, 'w');
            $this->setCsvHeader($df);
            $request->merge(['paginate' => 1]);
            $rpp = 2000;
            $request->merge(['rpp' => 1]);
            $result = $repo->pager($query);
            $total = $result->total();
            $perPage = $rpp;
            $request->merge(['rpp' => 2000]);
            $userCache = [];
            for ($page = 0; $page <= $total; $page = $page + $perPage) {
                $pageVal = intval($total / ($page + $perPage)) + 1;
                $request->merge(['page' => $pageVal]);
                $result = $repo->pager($query);
                foreach ($result as $key => $data) {
                    $this->setCsvContent($data, $df);
                }
            }
            fclose($df);
            $logDownload->status = 'ready';
            $logDownload->save();
            $user = $request->user();

            switch ($request->input('type')) {
                case 'sent':
                    $message = 'User-to-User report generated at ' . $logDownload->created_at . ' is ready.';
                    $subject = 'User-to-User Report Generation Process Complete';
                    break;
                case 'received':
                    $message = 'System-to-User report generated at ' . $logDownload->created_at . ' is ready.';
                    $subject = 'System-to-User Report Generation Process Complete';
                    break;
                case 'spent':
                    $message = 'ACE e-Store transaction report generated at ' . $logDownload->created_at . ' is ready.';
                    $subject = 'ACE e-Store Transaction Report Generation Process Complete';
                    break;
            }
            $isPreview = false;
            $admin = $request->user();
            $user = $request->user();
            Mail::to($admin->email)->send(
                new AdminLogMail($user, $message, $subject, $isPreview)
            );
            return ApiResponse::success(['success' => 1]);
        }

        $result = $repo->pager($query);

        if ($result instanceof \Exception) {
            return ApiResponse::exception(
                ApiException::serverError($result->message())
            );
        }

        if ($request->has('download')) {

            ini_set('max_execution_time', 1800);
            $xlsx = $this->createSpreadsheet($result);
            return response()->download($xlsx);
        }

        return ApiResponse::success($result);
    }

    public function setCsvContent($data, $df)
    {
        $datetime = explode(' ', $data->created_at);
        $request = request();
        switch ($request->input('type')) {
            case 'sent':
                $row = [
                    $data->id,
                    $data->sender->name,
                    $data->sender->position_name,
                    $data->sender->career_level,
                    $data->sender->department_name,
                    $datetime[0],
                    $datetime[1],
                    $data->recipient->name,
                    $data->recipient->position_name,
                    $data->recipient->career_level,
                    $data->recipient->department_name,
                    $data->credits,
                    $data->token_expiration,
                    $data->badge->name,
                    $data->message,
                ];
                fputcsv($df, $row);
                break;
            case 'received':
                $row = [
                    $data->id,
                    $data->user->name,
                    $data->user->department_name,
                    $data->user->position_name,
                    $data->user->career_level,
                    $data->amount,
                    $datetime[0],
                    $datetime[1],
                ];
                fputcsv($df, $row);
                break;
            case 'spent':
                foreach ($data->redeem_items as $item) {
                    $row = [
                        $data->order_number,
                        $item->inventory->name,
                        $item->quantity,
                        $item->total_credits,
                        $data->user->name,
                        $data->user->department_name,
                        $data->user->position_name,
                        $data->user->career_level,
                        $datetime[0],
                        $datetime[1],
                    ];
                    fputcsv($df, $row);
                }
                break;
        }
    }

    public function setCsvHeader($csvFile)
    {
        $request = request();
        switch ($request->input('type')) {
            default:
            case 'sent':
                fputcsv($csvFile, [
                   'ID',
                   'SENDER',
                   'DESIGNATION',
                   'CAREER LEVEL',
                   'DEPARTMENT',
                   'SEND DATE',
                   'SEND TIME',
                   'RECEIVER',
                   'DESIGNATION',
                   'CAREER LEVEL',
                   'DEPARTMENT',
                   'TOKENS',
                   'TOKENS EXPIRY DATE',
                   'BADGE',
                   'MESSAGE',
                ]);
                break;
            case 'received':
                fputcsv($csvFile, [
                   'ID',
                   'USER',
                   'DEPARTMENT',
                   'DESIGNATION',
                   'CAREER LEVEL',
                   'TOKENS RECEIVED',
                   'DATE',
                   'TIME',
                ]);
                break;
            case 'spent':
                fputcsv($csvFile, [
                   'ORDER #',
                   'ITEM',
                   'QUANTITY',
                   'TOTAL',
                   'USER',
                   'DEPARTMENT',
                   'DESIGNATION',
                   'CAREER LEVEL',
                   'DATE',
                   'TIME',
                ]);
                break;
        }
    }

    public function createSpreadsheet($data)
    {
        $request = request();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $this->setSpreadsheetHeader($sheet);

        for ($x = 0, $xx = 0; $x < count($data); $x++) {
            $xx = $this->setSpreadsheetRow($sheet, ($xx+2), $data[$x]);
        }

        $xlsx = new Xlsx($spreadsheet);

        $filename = $this->setSpreadsheetFilename();

        $savePath = storage_path("app/reports/$filename");

        $xlsx->save($savePath);

        return $savePath;
    }

    public function setSpreadsheetHeader($sheet)
    {
        $request = request();

        switch ($request->input('type')) {
            default:
            case 'sent':
                $sheet->setCellValue('A1', 'ID');
                $sheet->setCellValue('B1', 'SENDER');
                $sheet->setCellValue('C1', 'DESIGNATION');
                $sheet->setCellValue('D1', 'CAREER LEVEL');
                $sheet->setCellValue('E1', 'DEPARTMENT');
                $sheet->setCellValue('F1', 'SEND DATE');
                $sheet->setCellValue('G1', 'SEND TIME');
                $sheet->setCellValue('H1', 'RECEIVER');
                $sheet->setCellValue('I1', 'DESIGNATION');
                $sheet->setCellValue('J1', 'CAREER LEVEL');
                $sheet->setCellValue('K1', 'DEPARTMENT');
                $sheet->setCellValue('L1', 'TOKENS');
                $sheet->setCellValue('M1', 'TOKENS EXPIRY DATE');
                $sheet->setCellValue('N1', 'BADGE');
                $sheet->setCellValue('O1', 'MESSAGE');
                break;
            case 'received':
                $sheet->setCellValue('A1', 'ID');
                $sheet->setCellValue('B1', 'USER');
                $sheet->setCellValue('C1', 'DEPARTMENT');
                $sheet->setCellValue('D1', 'DESIGNATION');
                $sheet->setCellValue('E1', 'CAREER LEVEL');
                $sheet->setCellValue('F1', 'TOKENS RECEIVED');
                $sheet->setCellValue('G1', 'DATE');
                $sheet->setCellValue('H1', 'TIME');
                break;
            case 'spent':
                $sheet->setCellValue('A1', 'ORDER #');
                $sheet->setCellValue('B1', 'ITEM');
                $sheet->setCellValue('C1', 'QUANTITY');
                $sheet->setCellValue('D1', 'TOTAL');
                $sheet->setCellValue('E1', 'USER');
                $sheet->setCellValue('F1', 'DEPARTMENT');
                $sheet->setCellValue('G1', 'DESIGNATION');
                $sheet->setCellValue('H1', 'CAREER LEVEL');
                $sheet->setCellValue('I1', 'DATE');
                $sheet->setCellValue('J1', 'TIME');
                break;
        }
    }

    public function setSpreadsheetRow($sheet, $row, $data)
    {
        $request = request();

        switch ($request->input('type')) {
            default:
            case 'sent':
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->toDateString();
                $time = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('H:i:s');

                $sheet->setCellValue("A$row", $data->id);
                $sheet->setCellValue("B$row", $data->sender->name);
                $sheet->setCellValue("C$row", $data->sender->position_name);
                $sheet->setCellValue("D$row", $data->sender->career_level);
                $sheet->setCellValue("E$row", $data->sender->department_name);
                $sheet->setCellValue("F$row", $date);
                $sheet->setCellValue("G$row", $time);
                $sheet->setCellValue("H$row", $data->recipient->name);
                $sheet->setCellValue("I$row", $data->recipient->position_name);
                $sheet->setCellValue("J$row", $data->recipient->career_level);
                $sheet->setCellValue("K$row", $data->recipient->department_name);
                $sheet->setCellValue("L$row", $data->credits);
                $sheet->setCellValue("M$row", $data->token_expiration);
                $sheet->setCellValue("N$row", $data->badge->name);
                $sheet->setCellValueExplicit(
                    "O$row",
                    $data->message,
                    \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING
                );
                $row++;
                break;
            case 'received':
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->toDateString();
                $time = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('H:i:s');

                $sheet->setCellValue("A$row", $data->id);
                $sheet->setCellValue("B$row", $data->user->name);
                $sheet->setCellValue("C$row", $data->user->department_name);
                $sheet->setCellValue("D$row", $data->user->position_name);
                $sheet->setCellValue("E$row", $data->user->career_level);
                $sheet->setCellValue("F$row", $data->amount);
                $sheet->setCellValue("G$row", $date);
                $sheet->setCellValue("H$row", $time);
                $row++;
                break;
            case 'spent':
                foreach ($data->redeem_items as $item) {
                    $date = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->toDateString();
                    $time = Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('H:i:s');
                    $sheet->setCellValue("A$row", $data->order_number);
                    $sheet->setCellValue("B$row", $item->inventory->name);
                    $sheet->setCellValue("C$row", $item->quantity);
                    $sheet->setCellValue("D$row", $item->total_credits);
                    $sheet->setCellValue("E$row", $data->user->name);
                    $sheet->setCellValue("F$row", $data->user->department_name);
                    $sheet->setCellValue("G$row", $data->user->position_name);
                    $sheet->setCellValue("H$row", $data->user->career_level);
                    $sheet->setCellValue("I$row", $date);
                    $sheet->setCellValue("J$row", $time);
                    $row++;
                }
                break;
        }

        return $row-2;
    }

    public function setSpreadsheetFilename()
    {
        $request = request();

        $dt = date('YMD_His');

        switch ($request->input('type')) {
            default:
            case 'sent':
                $result = "report_sent_tokens_$dt.xlsx";
                break;
            case 'received':
                $result = "report_received_tokens_$dt.xlsx";
                break;
            case 'spent':
                $result = "report_spent_tokens_$dt.xlsx";
                break;
        }

        return $result;
    }
}
