<?php

namespace App\Http\Controllers\Rewards;

use App\Events\GreenTokenLogEvent;
use App\Http\Controllers\Controller;
use App\Mail\CheckoutMail;
use App\Models\GreenTokenLog;
use App\Mail\RedeemMail;
use App\Repositories\CartItemRepository;
use App\Repositories\InventoryRepository;
use App\Repositories\RedeemRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

class CheckoutController extends Controller
{
    /**
     * @todo add force parameter
     */
    public function checkout(
        Request $request,
        CartItemRepository $cartItemRepo,
        RedeemRepository $redeemRepo,
        InventoryRepository $inventoryRepo,
        UserRepository $userRepo
    ) {
        try {
            DB::beginTransaction();

            $user  = $request->user();

            // Get items from cart
            $items = $cartItemRepo->where('user_id', $user->id)->get();

            if ($items instanceof ApiException) {
                return ApiResponse::exception($items);
            }

            // Get total quantity and sum of cart items
            $redeemQty   = $items->sum('quantity');
            $redeemTotal = $items->sum('total');

            if ($redeemQty <= 0)
            {
                throw ApiException::badRequest([
                    __('checkout.zeroQuantity'),
                ]);
            }
            // Check if user has enough credit
            if ($user->credits < $redeemTotal) {
                throw ApiException::badRequest([
                    __('checkout.insufficientCredits'),
                ]);
            }

            // Create redeems model
            $redeem = $redeemRepo->create([
                'user_id'  => $user->id,
                'quantity' => $redeemQty,
                'total_credits' => $redeemTotal,
            ]);

            // Create errors array
            $errors = [];

            // Create redeems transaction models
            foreach ($items as $item) {
                if ($item->inventory->stock < $item->quantity) {
                    // Push error item if stock is insufficient or unavailable
                    $errors[] = $item->inventory->stock === 0
                        ? __('checkout.stock.unavailable', [
                            'item' => $item->inventory->name,
                        ])
                        : __('checkout.stock.insufficient', [
                            'item'  => $item->inventory->name,
                            'stock' => $item->inventory->stock
                        ]);

                    continue;
                }

                $redeemRepo->attachTransaction($redeem, $item);

                // Calculate the amount to de deducted from stock
                $debitAmount = $item->quantity * -1;
                // Log the inventory action
                $inventoryRepo->log($item->inventory_id, $debitAmount);
                // Reduce the stock amount in inventory
                $inventoryRepo->where('id', $item->inventory_id)->decrement('stock', $item->quantity);
            }

            // Check if there were errors upon attaching transaction items
            if (count($errors)) {
                throw ApiException::badRequest($errors);
            }

            // Clear cart
            $cartItemRepo->clear($user->id);

            // Reduce the credit of user
            $this->logGreenToken($user->id, $redeemTotal);

            DB::commit();
        } catch (ApiException $e) {
            DB::rollBack();
            return ApiResponse::exception($e);
        }

        $date = Carbon::now()->format('d F Y');
        $orderDate = Carbon::createFromFormat('Y-m-d H:i:s', $redeem->created_at)->format('d F Y, h:i A');
        $collectionDate = Carbon::createFromFormat('Y-m-d', $redeem->collection_date)->format('d F Y');
        $orderItems = [];

        foreach ($redeem->redeem_items as $ri) {
            $orderItems[] = [
                'inventory' => $ri->inventory,
                'quantity' => $ri->quantity,
                'tokens' => $ri->total_credits,
            ];
        }

        // Send mail to user
        Mail::to($user->email)->send(new RedeemMail(
           $request->user(),
           $orderItems,
           $redeem->total_credits,
           $redeem->order_number,
           $date,
           $orderDate,
           $collectionDate,           
           $isPreview = false,
           $editpreview = false,
           $message = ""
        ));

        return $redeem;
    }

    protected function logGreenToken($user_id, $redeemTotal)
    {
        $amount = -1 * $redeemTotal;

        event(new GreenTokenLogEvent(
            $user_id,
            GreenTokenLog::ACTION_DEBIT,
            GreenTokenLog::TYPE_REDEEM,
            $amount,
            "REDEEM",
            $user_id
        ));
    }
}
