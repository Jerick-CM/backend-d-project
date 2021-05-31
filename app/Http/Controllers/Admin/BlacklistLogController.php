<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlacklistLog;
use App\Repositories\BlacklistLogRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

class BlacklistLogController extends Controller
{
    public function index(Request $request, BlacklistLogRepository $blacklistLogRepo)
    {
        $result = $blacklistLogRepo->pager($blacklistLogRepo);

        if ($result instanceof \Exception) {
            return ApiResponse::exception(ApiException::serverError($result->getMessage()));
        }

        return ApiResponse::success($result);
    }

    public function show($blacklist_log_id, Request $request, UserRepository $userRepo)
    {
        if ($blacklist_log_id === 'latest') {
            $result = BlacklistLog::orderBy('id', 'desc')->first();
        } else {
            $result = BlacklistLog::find($blacklist_log_id);
        }

        if (! $result) {
            return ApiResponse::success();
        }

        return ApiResponse::success($userRepo->pager($result->users()));
    }
}
