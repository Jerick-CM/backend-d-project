<?php

namespace App\Http\Requests\Admin\Inventory;

use Takaworx\Brix\Http\Requests\BaseFormRequest;

class UpdateInventoryRequest extends BaseFormRequest
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
            'id' => 'filled|integer|exists:inventory,id',
            'photo' => 'file',
            'unit_price' => 'filled|integer',
            'is_visible' => 'filled|boolean',
            'is_preorder'  => 'filled|boolean',
            'categories'   => 'filled|array',
            'categories.*' => 'exists:categories,id',
            'short_desc'   => 'max:50',
            'meta'         => 'filled|array',
            'meta.*.key'   => 'required_with:meta',
            'meta.*.val'   => 'required_with:meta',
        ];
    }

    public function messages()
    {
        return [
            'unit_price.filled' => __('validation.inventory_price_required'),
            'unit_price.integer' => __('validation.inventory_price_integer'),
            'description.filled' => __('validation.inventory_desc_required'),
            'description.max' => __('validation.inventory_desc_max'),
            'short_desc.filled' => __('validation.inventory_short_desc_required'),
            'short_desc.max' => __('validation.inventory_short_desc_max'),
        ];
    }
}
