<?php

namespace App\Http\Controllers\Rewards;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

class CategoryController extends Controller
{
    public function index(Request $request, CategoryRepository $categoryRepo)
    {
        $result = $categoryRepo->pager($categoryRepo);

        if ($result instanceof \Exception) {
            return ApiResponse::exception(ApiException::serverError($result->getMessage()));
        }

        return ApiResponse::success($result);
    }
}
