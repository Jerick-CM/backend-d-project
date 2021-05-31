<?php

namespace App\Http\Controllers\Admin;

use App\Events\AdminLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Positions\UpdatePositionRequest;
use App\Models\AdminLog;
use App\Repositories\PositionRepository;
use Illuminate\Http\Request;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

class PositionsController extends Controller
{
    /**
     * Get a page of the positions
     *
     * @param Request $request
     * @param PositionRepository $positionRepo
     */
    public function index(Request $request, PositionRepository $positionRepo)
    {
        $query = $positionRepo;

        $query = $query->setAppendRelationsCount(true)->joinRelations('users');

        if ($request->filled('sort') && explode(':', $request->sort)[0] === 'users_count') {
            $direction = explode(':', $request->sort)[1];
            $query = $query->orderByJoin('users.id', $direction, 'COUNT');
        }

        $positions = $positionRepo->pager($query);

        if ($positions instanceof \Exception) {
            return ApiResponse::exception(ApiException::serverError($positions->getMessage()));
        }

        return ApiResponse::success($positions);
    }

    /**
     * Update monthly token allocation / max token send to one user of each position
     *
     * @param $request
     * @param PositionRepository $positionRepo
     */
    public function update(UpdatePositionRequest $request, PositionRepository $positionRepo)
    {
        $result = [];

        foreach ($request->input('positions') as $p) {
            $id = $p['id'];

            $data = [
                'monthly_token_allocation' => intval($p['monthly_token_allocation']),
                'max_token_send_to_same_user' => intval($p['max_token_send_to_same_user']),
            ];

            $position = $positionRepo->find($id);

            if ($position->monthly_token_allocation !== intval($p['monthly_token_allocation'])) {
                $this->logPositionMonthlyAllocation($request->user(), $position, $p['monthly_token_allocation']);
            }

            if ($position->max_token_send_to_same_user !== intval($p['max_token_send_to_same_user'])) {
                $this->logPositionSendLimit($request->user(), $position, $p['max_token_send_to_same_user']);
            }

            $update = $positionRepo->where('id', $id)->update($data);

            if ($update instanceof \Exception) {
                $result[$id] = __('positions.update.failed', [
                    'position' => $position->name,
                ]);
            } else {
                $result[$id] = __('positions.update.success', [
                    'position' => $position->name,
                ]);
            }
        }

        return ApiResponse::success($result);
    }

    protected function logPositionMonthlyAllocation($admin, $position, $input)
    {
        try {
            $input = intval($input);

            $type = $input > $position->monthly_token_allocation
                ? AdminLog::TYPE_USER_LEVEL_ALLOWANCE_INCREASE
                : AdminLog::TYPE_USER_LEVEL_ALLOWANCE_DECREASE;

            event(new AdminLogEvent($admin->id, $type, [
                'admin' => $admin->name,
                'position' => $position->name,
                'amount' => $input,
            ]));
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    protected function logPositionSendLimit($admin, $position, $input)
    {
        try {
            $input = intval($input);

            $type = $input > $position->max_token_send_to_same_user
                ? AdminLog::TYPE_USER_LEVEL_SEND_LIMIT_INCREASE
                : AdminLog::TYPE_USER_LEVEL_SEND_LIMIT_DECREASE;

            event(new AdminLogEvent($admin->id, $type, [
                'admin' => $admin->name,
                'position' => $position->name,
                'amount' => $input,
            ]));
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
