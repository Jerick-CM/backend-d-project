<?php

namespace App\Http\Controllers\Rewards;

use App\Http\Controllers\Controller;
use App\Repositories\DepartmentRepository;
use Illuminate\Http\Request;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

class DepartmentsController extends Controller
{
    public function index(Request $request, DepartmentRepository $departmentRepo)
    {
        $result = $departmentRepo->pager($departmentRepo);

        if ($result instanceof \Exception) {
            return ApiResponse::exception(ApiException::serverError($result->getMessage()));
        }

        return ApiResponse::success($result);
    }
}
