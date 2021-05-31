<?php

namespace App\Http\Controllers\Rewards;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Repositories\BannerRepository;
use Illuminate\Http\Request;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

class BannersController extends Controller
{
    public function index(Request $request, BannerRepository $bannerRepo)
    {
        $query  = $bannerRepo->orderBy('order', 'asc');

        if ($request->filled('type') && intval($request->input('type')) === 1) {
            $query = $query->where('type', Banner::TYPE_REDEEM);
        } else {
            $query = $query->where('type', Banner::TYPE_MAIN);
        }

        $result = $bannerRepo->pager($query);

        if ($result instanceof \Exception) {
            return ApiResponse::exception(ApiException::serverError($result->getMessage()));
        }

        return ApiResponse::success($result);
    }
}
