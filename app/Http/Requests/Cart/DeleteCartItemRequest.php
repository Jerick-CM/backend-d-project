<?php

namespace App\Http\Requests\Cart;

use App\Models\CartItem;
use Takaworx\Brix\Http\Requests\BaseFormRequest;

class DeleteCartItemRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $inventory_id = $this->route('inventory_id');

        $cartItem = CartItem::where([
            'user_id'      => $this->user()->id,
            'inventory_id' => $inventory_id,
        ]);

        if (! $cartItem) {
            return false;
        }
        
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
