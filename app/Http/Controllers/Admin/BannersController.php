<?php

namespace App\Http\Controllers\Admin;

use App\Events\AdminLogEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Banners\StoreBannerRequest;
use App\Http\Requests\Banners\UpdateBannerRequest;
use App\Http\Requests\Banners\DeleteBannerRequest;
use App\Http\Requests\Banners\SortBannerRequest;
use App\Models\AdminLog;
use App\Models\Banner;
use App\Repositories\BannerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

class BannersController extends Controller
{
    public function index(Request $request, BannerRepository $bannerRepo)
    {
        $query = $bannerRepo->orderBy('order', 'asc');

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

    public function store(StoreBannerRequest $request, BannerRepository $bannerRepo)
    {
        $file = $bannerRepo->uploadPhoto();

        if (! $request->has('action') || is_null($request->action)) {
            $request->request->add([
                'action' => '#'
            ]);
        }

        if ($file instanceof \Exception) {
            return ApiResponse::exception(ApiException::serverError($file->getMessage()));
        }

        if (! $request->has('type')) {
            $request->request->add(['type' => Banner::TYPE_MAIN]);
        }

        $data = [
            'title'  => $request->input('title'),
            'action' => $request->input('action'),
            'type'   => $request->input('type'),
            'file'   => $file,
        ];

        $currentBannerCount = $bannerRepo->where('type', $data['type'])->count();

        $isMainBannerExceeded = intval($data['type']) === Banner::TYPE_MAIN
            && $currentBannerCount >= Banner::MAX_MAIN_BANNERS;

        $isRedeemBannerExceeded = intval($data['type']) === Banner::TYPE_REDEEM
            && $currentBannerCount >= Banner::MAX_REDEEM_BANNERS;

        \Log::info('banner:' . $data['type']);

        if ($isMainBannerExceeded || $isRedeemBannerExceeded) {
            return ApiResponse::exception(ApiException::serverError(__('banners.exceeded')));
        }

        if ($request->filled('is_open_in_new_tab')) {
            $data['is_open_in_new_tab'] = $request->input('is_open_in_new_tab');
        }

        $banner = $bannerRepo->create($data);

        if ($banner instanceof \Exception) {
            return ApiResponse::exception(ApiException::serverError($banner->getMessage()));
        }

        if (Banner::TYPE_MAIN === intval($request->type)) {
            $type = AdminLog::TYPE_CAROUSEL_HOME_NEW;
        } else {
            $type = AdminLog::TYPE_CAROUSEL_STORE_NEW;
        }

        event(new AdminLogEvent($request->user()->id, $type, [
            'admin'  => $request->user()->name,
        ]));

        return ApiResponse::success($banner);
    }

    public function update($banner_id, UpdateBannerRequest $request, BannerRepository $bannerRepo)
    {
        $data = $request->only('title', 'action', 'is_open_in_new_tab');

        $banner = $bannerRepo->find($banner_id);

        if (! $request->has('action') || is_null($request->action)) {
            $request->request->add([
                'action' => '#'
            ]);
        }

        if ($banner->action !== $request->input('action')) {
            $this->logBannerLink($request->user(), $banner->type);
        }

        if ($banner->title !== $request->input('title')) {
            $this->logBannerTitle($request->user(), $banner->type);
        }

        $updateBannerData = $bannerRepo->where('id', $banner_id)->update($data);

        if ($updateBannerData instanceof \Exception) {
            return ApiResponse::exception(ApiException::serverError($updateBannerData->getMessage()));
        }

        $banner = $bannerRepo->find($banner_id);

        if (! $request->has('photo')) {
            return ApiResponse::success($banner);
        }

        $file = $bannerRepo->updatePhoto();

        if ($file instanceof \Exception) {
            \Log::info('file ', $file);
            return ApiResponse::exception(ApiException::serverError($file->getMessage()));
        }

        $banner->file = $file;
        $banner->save();

        return ApiResponse::success($banner);
    }

    public function delete($banner_id, DeleteBannerRequest $request, BannerRepository $bannerRepo)
    {
        try {
            $banner = $bannerRepo->find($banner_id);
            $deleteFile = $bannerRepo->deletePhoto($banner_id);
            $deleteRecord = $bannerRepo->where('id', $banner_id)->delete();
        } catch (\Exception $e) {
            return ApiResponse::exception(ApiException::serverError($e->getMessage()));
        }

        event(new AdminLogEvent($request->user()->id, AdminLog::TYPE_BANNER_DELETE, [
            'user'  => $request->user()->name,
            'title' => $banner->title,
        ]));

        return ApiResponse::success(true);
    }

    public function sort(SortBannerRequest $request, BannerRepository $bannerRepo)
    {
        try {
            DB::beginTransaction();

            $orders = [];

            foreach ($request->input('banners') as $banner) {
                if (in_array($banner['order'], $orders)) {
                    throw new \Exception("Duplicate orders detected");
                }

                $bannerRepo->where('id', $banner['id'])->update([
                    'order' => $banner['order']
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::exception(ApiException::serverError($e->getMessage()));
        }

        return ApiResponse::success();
    }

    protected function logBannerLink($admin, $banner_type)
    {
        try {
            $type = Banner::TYPE_MAIN === intval($banner_type)
                ? AdminLog::TYPE_CAROUSEL_HOME_UPDATE_LINK
                : AdminLog::TYPE_CAROUSEL_STORE_UPDATE_LINK;

            event(new AdminLogEvent($admin->id, $type, [
                'admin' => $admin->name,
            ]));
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    protected function logBannerTitle($admin, $banner_type)
    {
        try {
            $type = Banner::TYPE_MAIN === intval($banner_type)
                ? AdminLog::TYPE_CAROUSEL_HOME_UPDATE_TITLE
                : AdminLog::TYPE_CAROUSEL_STORE_UPDATE_TITLE;

            event(new AdminLogEvent($admin->id, $type, [
                'admin' => $admin->name,
            ]));
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
