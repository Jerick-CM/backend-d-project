<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\RedeemRepository;
use Illuminate\Http\Request;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

class RedeemController extends Controller
{
    public function index(Request $request, RedeemRepository $redeemRepo)
    {
        $redeems = $redeemRepo->pager($redeemRepo);

        if ($redeems instanceof \Exception) {
            return ApiResponse::exception(ApiException::serverError($redeems->getMessage()));
        }

        return ApiResponse::success($redeems);
    }
}
