<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Departments\UpdateDepartmentsRequest;
use App\Repositories\DepartmentRepository;
use Illuminate\Http\Request;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

class DepartmentsController extends Controller
{
    public function update($department_id, UpdateDepartmentsRequest $request, DepartmentRepository $departmentRepo)
    {
        try {
            $departmentRepo->where('id', $department_id)->update($request->only('short_name'));
        } catch (\Exception $e) {
            ApiResponse::exception(ApiException::serverError($e->getMessage()));
        }

        return ApiResponse::success($departmentRepo->find($department_id));
    }
}
