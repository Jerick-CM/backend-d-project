<?php

namespace App\Http\Requests\Admin\Inventory;

use Takaworx\Brix\Http\Requests\BaseFormRequest;

class StoreInventoryRequest extends BaseFormRequest
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
            'name'  => 'required',
            'stock' => 'integer',
            'photos' => 'array',
            'photos.*.file' => 'file',
            'unit_price'   => 'required|integer',
            'is_visible'   => 'required|boolean',
            'is_preorder'  => 'required|boolean',
            'categories'   => 'filled|array',
            'categories.*' => 'exists:categories,id',
            'short_desc'   => 'max:50',
            'meta'         => 'filled|array',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.inventory_name_required'),
            'stock.integer' => __('validation.inventory_stock_integer'),
            'unit_price.required' => __('validation.inventory_price_required'),
            'unit_price.integer' => __('validation.inventory_price_integer'),
            'description.filled' => __('validation.inventory_desc_required'),
            'description.max' => __('validation.inventory_desc_max'),
            'short_desc.filled' => __('validation.inventory_short_desc_required'),
            'short_desc.max' => __('validation.inventory_short_desc_max'),
        ];
    }
}
