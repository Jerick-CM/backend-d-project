<?php

namespace App\Http\Controllers\Rewards;

use App\Http\Controllers\Controller;
use App\Repositories\PositionRepository;
use Illuminate\Http\Request;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

class PositionsController extends Controller
{
    public function index(Request $request, PositionRepository $positionRepo)
    {
        $result = $positionRepo->pager($positionRepo);

        if ($result instanceof \Exception) {
            return ApiResponse::exception(ApiException::serverError($result->getMessage()));
        }

        return ApiResponse::success($result);
    }
}
