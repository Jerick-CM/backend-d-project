<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Validation\Rule;
use Takaworx\Brix\Http\Requests\BaseFormRequest;

class UpdateCategoryRequest extends BaseFormRequest
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
            'name' => [
                'filled',
                'max:32',
                Rule::unique('categories')->ignore($this->route('category_id'))
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.filled' => __('validation.category_name_required'),
            'name.max' => __('validation.category_name_max'),
        ];
    }
}
