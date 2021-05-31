<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserLevels\UpdateUserLevelsRequest;
use App\Repositories\UserLevelRepository;
use Illuminate\Http\Request;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

class UserLevelsController extends Controller
{
    public function index(Request $request, UserLevelRepository $userLevelRepo)
    {
        try {
            $result = $userLevelRepo->pager($userLevelRepo);
        } catch (\Exception $e) {
            return ApiResponse::exception(ApiException::serverError($e->getMessage()));
        }

        return ApiResponse::success($result);
    }

    public function update($user_level_id, UpdateUserLevelsRequest $request, UserLevelRepository $userLevelRepo)
    {
        try {
            $userLevelRepo->where('id', $user_level_id)
                ->update($request->only('monthly_token_allocation', 'max_token_send_to_same_user'));
        } catch (\Exception $e) {
            return ApiResponse::exception(ApiException::serverError($e->getMessage()));
        }

        return ApiResponse::success($userLevelRepo->find($user_level_id));
    }
}
