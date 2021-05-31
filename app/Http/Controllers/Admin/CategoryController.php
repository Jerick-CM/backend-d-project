<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
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

    public function store(StoreCategoryRequest $request, CategoryRepository $categoryRepo)
    {
        try {
            $category = $categoryRepo->create($request->only('name'));
        } catch (\Exception $e) {
            return ApiResponse::exception(ApiException::serverError($e->getMessage()));
        }

        return ApiResponse::success($category);
    }

    public function update($category_id, UpdateCategoryRequest $request, CategoryRepository $categoryRepo)
    {
        try {
            $category = $categoryRepo->where('id', $category_id)->update($request->only('name'));
        } catch (\Exception $e) {
            return ApiResponse::exception(ApiException::serverError($e->getMessage()));
        }

        return ApiResponse::success($categoryRepo->find($category_id));
    }

    public function delete($category_id, CategoryRepository $categoryRepo)
    {
        try {
            $categoryRepo->where('id', $category_id)->delete();
        } catch (\Exception $e) {
            return ApiResponse::exception(ApiException::serverError($e->getMessage()));
        }

        return ApiResponse::success();
    }
}
