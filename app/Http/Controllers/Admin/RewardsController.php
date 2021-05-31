<?php

namespace App\Http\Controllers\Admin;


use App\Events\AdminLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Inventory\CreditRequest;
use App\Http\Requests\Admin\Inventory\DebitRequest;
use App\Http\Requests\Admin\Inventory\PhotoSortRequest;
use App\Http\Requests\Admin\Inventory\PhotoUploadRequest;
use App\Http\Requests\Admin\Inventory\StoreInventoryRequest;
use App\Http\Requests\Admin\Inventory\UpdateInventoryRequest;
use App\Mail\AdminLogMail;
use App\Models\AdminLog;
use App\Models\LogDownloads;
use App\Models\RedeemTransaction;
use App\Repositories\CartItemRepository;
use App\Repositories\InventoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

class RewardsController extends Controller
{
    public function index(Request $request, InventoryRepository $inventoryRepo)
    {
        $items = $inventoryRepo->pager($inventoryRepo);
        if ($items instanceof \Exception) {
            return ApiResponse::exception(ApiException::serverError($items->getMessage()));
        }

        if ($request->has('download')) {
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
            $logDownload->type = 'Inventory Management';
            $logDownload->save();
            $now = gmdate("D, d M Y H:i:s");
            $savePath = storage_path("app/reports/$filename");
            $df = fopen($savePath, 'w');
            fputcsv($df, [
                'Product Name',
                'Item Value',
                'Quantity Available remaining stock',
                'No of Redemptions',
            ]);
            $request->merge(['paginate' => 1]);
            $rpp = 2000;
            $request->merge(['rpp' => 1]);
            $result = $inventoryRepo->pager($inventoryRepo);
            $total = $result->total();
            $perPage = $rpp;
            $request->merge(['rpp' => 2000]);
            $userCache = [];
            for ($page = 0; $page <= $total; $page = $page + $perPage) {
                $pageVal = intval($total / ($page + $perPage)) + 1;
                $request->merge(['page' => $pageVal]);
                $result = $inventoryRepo->pager($inventoryRepo);
                foreach ($result as $key => $data) {
                    $row = [
                        $data->name,
                        $data->unit_price,
                        $data->stock,
                        RedeemTransaction::where('inventory_id', $data->id)->sum('quantity'),
                    ];
                    fputcsv($df, $row);
                }
            }
            fclose($df);
            $logDownload->status = 'ready';
            $logDownload->save();
            $user = $request->user();
            $message = 'Inventory management report generated at ' . $logDownload->created_at . ' is ready.';
            $subject = 'Inventory management Report Generation Process Complete';
            $isPreview = false;
            $admin = $request->user();
            $user = $request->user();
            Mail::to($admin->email)->send(
                new AdminLogMail($user, $message, $subject, $isPreview)
            );
            die();
        }

        return ApiResponse::success($items);
    }

    public function store(StoreInventoryRequest $request, InventoryRepository $inventoryRepo)
    {
        try {
            DB::beginTransaction();

            $data = $request->only('name', 'unit_price', 'is_preorder', 'is_visible');

            if ($request->filled('stock')) {
                $data['stock'] = $request->input('stock');
            } else {
                $data['stock'] = 0;
            }

            if ($request->filled('description')) {
                $data['description'] = $request->input('description');
            }

            if ($request->filled('short_desc')) {
                $data['short_desc'] = $request->input('short_desc');
            }

            if ($request->filled('meta')) {
                $data['meta'] = $request->input('meta');
            } else {
                $data['meta'] = [];
            }

            // Save item to invenetory
            $inventory = $inventoryRepo->create($data);

            // Sync categories if necessary
            if ($request->has('categories')) {
                $inventory->categories()->sync($request->categories);
                $inventory = $inventory->fresh();
            }

            // Log creation of inventory item
            $inventoryRepo->log($inventory->id, $data['stock'], true, false);

            // Save photos to inventory
            if ($request->has('photos')) {
                $i = 0;

                foreach ($request->photos as $photo) {
                    if ($i === 0) {
                        $isPrimary = true;
                    } else {
                        $isPrimary = false;
                    }

                    $inventoryPhoto = $inventoryRepo->storePhoto($inventory->id, $request, $isPrimary, $photo['file']);

                    $i++;
                }
            }

            // Log admin activity
            event(new AdminLogEvent($request->user()->id, AdminLog::TYPE_INVENTORY_NEW, [
                'admin' => $request->user()->name,
            ]));

            DB::commit();
        } catch (\Exception $e) {
            \Log::info($e);
            DB::rollBack();
            return ApiResponse::exception(ApiException::serverError($e->getMessage()));
        }

        return $inventory;
    }

    public function update($inventory_id, UpdateInventoryRequest $request, InventoryRepository $inventoryRepo)
    {
        try {
            $data = $request->only('name', 'unit_price', 'is_visible', 'is_preorder', 'description', 'short_desc');

            $product = $inventoryRepo->find($inventory_id);

            if ($request->input('name') !== $product->name) {
                $this->logUpdateProductName($request->user());
            }

            if ($request->has('photo')) {
                $this->logUpdateProductDP($request->user());
            }

            if (intval($request->input('unit_price')) !== $product->unit_price) {
                $this->logUpdateProductPrice($request->user());
            }

            if ($request->input('is_visible') != $product->is_visible && ! $request->input('is_visible')) {
                $this->logUpdateProductDiscontinue($request->user());
            }

            if ($request->input('is_preorder') != $product->is_preorder && $request->input('is_preorder')) {
                $this->logUpdateProductPreorder($request->user());
            }

            if ($request->filled('meta') && json_encode($request->input('meta')) !== json_encode($product->meta)) {
                $this->logUpdateProductMeta($request->user());
            }

            // Update the inventory item
            $inventoryRepo->where('id', $inventory_id)->update($data);

            // Get the updated inventory data
            $inventory = $inventoryRepo->find($inventory_id);

            // Update meta tag of inventory item
            if ($request->filled('meta')) {
                $inventory->meta = $request->input('meta');
            } else {
                $inventory->meta = [];
            }

            $inventory->save();

            // Sync categories if necessary
            if ($request->has('categories')) {
                $inventory->categories()->sync($request->categories);
                $inventory = $inventory->fresh();
            }

            // Do not change has to filled as it will NOT work
            if ($request->has('photo')) {
                $inventoryPhoto = $inventoryRepo->updatePhoto($inventory->primary_photo, $request);
                $inventory->primary_photo = $inventoryPhoto;
            }

            return ApiResponse::success($inventory);
        } catch (\Exception $e) {
            return ApiResponse::exception(ApiException::serverError($e->getMessage()));
        }
    }

    public function delete($inventory_id, InventoryRepository $inventoryRepo, CartItemRepository $cartItemRepo)
    {
        $exists = $inventoryRepo->where('id', $inventory_id)->count();

        if (! $exists) {
            return ApiResponse::exception(ApiException::notFound('Item not found!'));
        }

        DB::transaction(function () use ($inventory_id, $inventoryRepo, $cartItemRepo) {
            $cartItemRepo->where('inventory_id', $inventory_id)->delete();
            $inventoryRepo->where('id', $inventory_id)->delete();
        });

        return ApiResponse::success();
    }

    public function credit($inventory_id, CreditRequest $request, InventoryRepository $inventoryRepo)
    {
        try {
            DB::beginTransaction();

            $inventory = $inventoryRepo->where('id', $inventory_id)->first();

            $increment = $inventory->increment('stock', $request->input('amount'));

            // Log inventory action
            $inventoryRepo->log($inventory_id, $request->input('amount'), true, false);

            // Log admin activity
            event(new AdminLogEvent($request->user()->id, AdminLog::TYPE_REWARDS_CREDIT, [
                'user' => $request->user()->name,
                'item' => $inventory->name,
            ]));

            DB::commit();
        } catch (\Exception $e) {
            \Log::info($e);
            DB::rollBack();
            return ApiResponse::exception(ApiException::serverError($e->getMessage()));
        }

        return $inventoryRepo->find($inventory_id);
    }

    public function debit($inventory_id, DebitRequest $request, InventoryRepository $inventoryRepo)
    {
        try {
            DB::beginTransaction();

            $inventory = $inventoryRepo->where('id', $inventory_id)->first();

            $decrement = $inventory->decrement('stock', $request->input('amount'));

            // Log inventory action
            $amount = $request->input('amount') * -1;
            $inventoryRepo->log($inventory_id, $amount, true, false);

            // Log admin activity
            event(new AdminLogEvent($request->user()->id, AdminLog::TYPE_REWARDS_DEBIT, [
                'user' => $request->user()->name,
                'item' => $inventory->name,
            ]));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::exception(ApiException::serverError($e->getMessage()));
        }

        return $inventoryRepo->find($inventory_id);
    }

    public function photo($inventory_id, PhotoUploadRequest $request, InventoryRepository $inventoryRepo)
    {
        try {
            DB::beginTransaction();

            $result = [];

            foreach ($request->photos as $photo) {
                $inventoryPhoto = $inventoryRepo->storePhoto($inventory_id, $request, false, $photo['file']);
                $result[] = $inventoryPhoto;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::exception(ApiException::serverError($e->getMessage()));
        }

        return ApiResponse::success(collect($result));
    }

    public function sortPhoto($inventory_id, PhotoSortRequest $request, InventoryRepository $inventoryRepo)
    {
        try {
            DB::beginTransaction();

            foreach ($request->photos as $photo) {
                $sort = $inventoryRepo->sortPhoto($inventory_id, $photo['id'], $photo['order']);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::exception(ApiException::serverError($e->getMessage()));
        }

        return ApiResponse::success();
    }

    public function setPrimaryPhoto($inventory_id, $photo_id, Request $request, InventoryRepository $inventoryRepo)
    {
        try {
            DB::beginTransaction();

            $update = $inventoryRepo->setPrimaryPhoto($inventory_id, $photo_id);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::exception(ApiException::serverError($e->getMessage()));
        }
    }

    public function deletePhoto($inventory_id, $photo_id, InventoryRepository $inventoryRepo)
    {
        $delete = $inventoryRepo->deletePhotoFromDB($inventory_id, $photo_id);

        if ($delete instanceof \Exception) {
            return ApiResponse::exception(ApiException::serverError($delete->getMessage()));
        }

        return ApiResponse::success();
    }

    protected function logUpdateProductName($admin)
    {
        try {
            event(new AdminLogEvent($admin->id, AdminLog::TYPE_INVENTORY_UPDATE_NAME, [
                'admin' => $admin->name,
            ]));
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    protected function logUpdateProductDP($admin)
    {
        try {
            event(new AdminLogEvent($admin->id, AdminLog::TYPE_INVENTORY_UPDATE_DP, [
                'admin' => $admin->name,
            ]));
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    protected function logUpdateProductPrice($admin)
    {
        try {
            event(new AdminLogEvent($admin->id, AdminLog::TYPE_INVENTORY_UPDATE_PRICE, [
                'admin' => $admin->name,
            ]));
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    protected function logUpdateProductDiscontinue($admin)
    {
        try {
            event(new AdminLogEvent($admin->id, AdminLog::TYPE_INVENTORY_UPDATE_DISCONTINUE, [
                'admin' => $admin->name,
            ]));
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    protected function logUpdateProductPreorder($admin)
    {
        try {
            event(new AdminLogEvent($admin->id, AdminLog::TYPE_INVENTORY_UPDATE_PREORDER, [
                'admin' => $admin->name,
            ]));
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    protected function logUpdateProductMeta($admin)
    {
        try {
            event(new AdminLogEvent($admin->id, AdminLog::TYPE_INVENTORY_UPDATE_META, [
                'admin' => $admin->name,
            ]));
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }


    //// ADDED
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
        $sheet->setCellValue('A1', 'Product Name');
        $sheet->setCellValue('B1', 'Item Value');
        $sheet->setCellValue('C1', 'Quantity Available remaining stock');
        $sheet->setCellValue('D1', 'No of Redemptions');
    }

    public function setSpreadsheetRow($sheet, $row, $data)
    {
        $sheet->setCellValue("A$row", $data->name);
        $sheet->setCellValue("B$row", $data->unit_price);
        $sheet->setCellValue("C$row", $data->stock);
        $redemptions = RedeemTransaction::where('inventory_id', $data->id)->sum('quantity');
        $sheet->setCellValue("D$row", $redemptions);
    }

    public function setSpreadsheetFilename()
    {
        $dt = date('YMD_His');

        $result = "inventory_$dt.xlsx";

        return $result;
    }
}
