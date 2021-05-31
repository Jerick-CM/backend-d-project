<?php

namespace App\Http\Requests\Admin\Category;

use Takaworx\Brix\Http\Requests\BaseFormRequest;

class StoreCategoryRequest extends BaseFormRequest
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
            'name' => 'required|unique:categories,name|max:32',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.category_name_required'),
            'name.max' => __('validation.category_name_max'),
        ];
    }
}
