<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Repositories\RedeemRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

class RedeemController extends Controller
{
    public function history(Request $request, RedeemRepository $redeemRepo)
    {
        $query = $redeemRepo->where('user_id', $request->user()->id);

        if ($request->filled('from')) {
            $from = Carbon::createFromFormat('Y-m-d', $request->input('from'));
            $from->hour = 0;
            $from->minute = 0;
            $from->second = 0;
            $query = $query->where("{$redeemRepo->getTable()}.created_at", '>=', $from->toDateTimeString());
        }
        
        if ($request->filled('to')) {
            $to = Carbon::createFromFormat('Y-m-d', $request->input('to'));
            $to->hour = 23;
            $to->minute = 59;
            $to->second = 59;
            $query = $query->where("{$redeemRepo->getTable()}.created_at", '<=', $to->toDateTimeString());
        }

        $redeems = $redeemRepo->pager($query);

        if ($redeems instanceof \Exception) {
            return ApiResponse::exception(ApiException::serverError($redeems->getMessage()));
        }

        return ApiResponse::success($redeems);
    }
}
