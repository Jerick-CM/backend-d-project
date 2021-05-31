<?php

namespace App\Http\Requests\Admin\Inventory;

use App\Models\Inventory;
use Takaworx\Brix\Http\Requests\BaseFormRequest;

class DebitRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $id = $this->route('inventory_id');

        $inventory = Inventory::find($id);

        if (! $inventory) {
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
        return [
            'amount' => 'integer|required',
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => __('validation.inventory_debit_amount_required'),
            'amount.integer' => __('validation.inventory_debit_amount_integer'),
        ];
    }
}
