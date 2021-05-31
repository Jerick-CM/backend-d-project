<?php

namespace App\Http\Controllers\Rewards;

use App\Http\Controllers\Controller;
use App\Repositories\InventoryRepository;
use Illuminate\Http\Request;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

class ShopController extends Controller
{
    public function index(Request $request, InventoryRepository $inventoryRepository)
    {
        $query = $inventoryRepository
            ->where('stock', '>', 0)
            ->where('is_visible', 1);

        if ($request->has('category')) {
            $query = $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        $items = $inventoryRepository->pager($query);

        if ($items instanceof \Exception) {
            return ApiResponse::exception(
                ApiException::serverError($items->getMessage())
            );
        }

        return ApiResponse::success($items);
    }
}
