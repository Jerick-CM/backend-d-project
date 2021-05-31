<?php

namespace App\Http\Requests\Cart;

use Takaworx\Brix\Http\Requests\BaseFormRequest;

class AddCartItemRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:inventory,id',
            'quantity' => 'required|min:1',
        ];
    }
}
