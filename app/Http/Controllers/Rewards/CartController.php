<?php

namespace App\Http\Controllers\Rewards;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddCartItemRequest;
use App\Http\Requests\Cart\UpdateCartItemRequest;
use App\Http\Requests\Cart\DeleteCartItemRequest;
use App\Repositories\CartItemRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

class CartController extends Controller
{
    public function index(Request $request, CartItemRepository $cartItemRepo)
    {
        $items = $cartItemRepo->where('user_id', $request->user()->id)->get();

        if ($items instanceof ApiException) {
            return ApiResponse::exception($items);
        }

        return ApiResponse::success($items);
    }

    public function store(AddCartItemRequest $request, CartItemRepository $cartItemRepo)
    {
        $cartItem = $cartItemRepo->create([
            'user_id' => $request->user()->id,
            'inventory_id' => $request->input('id'),
            'quantity' => $request->input('quantity'),
        ]);

        $cartItem = $cartItemRepo->find($cartItem->id);

        if ($cartItem instanceof ApiException) {
            return ApiResponse::exception($cartItem);
        }

        return ApiResponse::success($cartItem);
    }

    public function update($inventory_id, UpdateCartItemRequest $request, CartItemRepository $cartItemRepo)
    {
        try {
            $cartItem = $cartItemRepo->where([
                    'user_id' => $request->user()->id,
                    'inventory_id' => $inventory_id
                ])
                ->first();
            
            $cartItem->quantity = $request->input('quantity');
            $cartItem->save();
        } catch (\Exception $e) {
            return ApiResponse::exception(ApiException::serverError($e->getMessage()));
        }

        return $cartItem;
    }

    public function delete($inventory_id, DeleteCartItemRequest $request, CartItemRepository $cartItemRepo)
    {
        try {
            $cartItem = $cartItemRepo->where([
                    'user_id' => $request->user()->id,
                    'inventory_id' => $inventory_id
                ])
                ->forceDelete();
        } catch (\Exception $e) {
            return ApiResponse::exception(ApiException::serverError($e->getMessage()));
        }

        return ApiResponse::success();
    }
}
