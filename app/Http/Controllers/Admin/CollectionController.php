<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CollectionHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Collection\StoreCollectionBlockRequest;
use App\Repositories\CollectionBlockRepository;
use App\Repositories\RedeemRepository;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

class CollectionController extends Controller
{
    public function index(Request $request, RedeemRepository $redeemRepo)
    {
        try {
            if (! $request->filled('date')) {
                throw new \Exception("date query is missing");
            }

            $query = $redeemRepo->where('collection_date', $request->date);

            $result = $redeemRepo->pager($query);

            return ApiResponse::success($result);
        } catch (\Exception $e) {
            return ApiResponse::exception(ApiException::serverError($e->getMessage()));
        }
    }

    public function blocks(Request $request, CollectionBlockRepository $collectionBlockRepo)
    {
        try {
            if (! $request->filled('date')) {
                throw new \Exception("date query is missing");
            }

            $start = Carbon::createFromFormat('Y-m', $request->date)->startOfMonth()->toDateString();
            $end   = Carbon::createFromFormat('Y-m', $request->date)->endOfMonth()->toDateString();

            $query = $collectionBlockRepo->whereBetween('date', [$start, $end]);

            $result = $collectionBlockRepo->pager($query);

            return ApiResponse::success($result);
        } catch (\Exception $e) {
            return ApiResponse::exception(ApiException::serverError($e->getMessage()));
        }
    }

    public function updateBlockDays(Request $request)
    {
        $blockDays = [
            'isMondayEnabled' => $request->input('isMondayEnabled'),
            'isTuesdayEnabled' => $request->input('isTuesdayEnabled'),
            'isWednesdayEnabled' => $request->input('isWednesdayEnabled'),
            'isThursdayEnabled' => $request->input('isThursdayEnabled'),
            'isFridayEnabled' => $request->input('isFridayEnabled'),
            'isSaturdayEnabled' => $request->input('isSaturdayEnabled'),
            'isSundayEnabled' => $request->input('isSundayEnabled'),
        ];
        $blockDays = json_encode($blockDays);
        Settings::where('setting', 'blockedDays')
          ->update(['data' => $blockDays]);
        return ApiResponse::success(['success'=>true]);
    }

    public function getBlockDays(Request $request)
    {
        $blockDays = Settings::where('setting', 'blockedDays', 1)->first();
        $blockDays = json_decode($blockDays['data'], true);
        return ApiResponse::success(['blockedDays' => $blockDays]);
    }

    public function storeBlock(StoreCollectionBlockRequest $request, CollectionBlockRepository $collectionBlockRepo)
    {
        try {
            DB::beginTransaction();

            $collectionBlock = $collectionBlockRepo->create($request->only('date'));

            $this->updateCollectionDate($request->date);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::exception(ApiException::serverError($e->getMessage()));
        }

        return ApiResponse::success($collectionBlock);
    }

    public function deleteBlock($collection_block_id, CollectionBlockRepository $collectionBlockRepo)
    {
        try {
            $collectionBlockRepo->where('id', $collection_block_id)->delete();
        } catch (\Exception $e) {
            return ApiResponse::exception(ApiException::serverError($e->getMessage()));
        }

        return ApiResponse::success();
    }

    protected function updateCollectionDate($date)
    {
        $redeemRepo = new RedeemRepository;

        $redeems = $redeemRepo->where('collection_date', $date)->get();

        if (! $redeems) {
            return true;
        }

        $nextCollectionDate = CollectionHelper::getNextCollectionDate($date);

        foreach ($redeems as $redeem) {
            $redeemRepo->where('id', $redeem->id)->update([
                'collection_date' => $nextCollectionDate,
            ]);
        }

        return true;
    }
}
