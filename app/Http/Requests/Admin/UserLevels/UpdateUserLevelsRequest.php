<?php

namespace App\Http\Requests\Admin\UserLevels;

use Takaworx\Brix\Http\Requests\BaseFormRequest;

class UpdateUserLevelsRequest extends BaseFormRequest
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
            'monthly_token_allocation' => 'filled|integer',
            'max_token_send_to_same_user' => 'filled|integer',
        ];
    }

    public function messages()
    {
        return [
            'monthly_token_allocation.filled' => __('validation.user_level_allocation_required'),
            'monthly_token_allocation.integer' => __('validation.user_level_allocation_integer'),
            'max_token_send_to_same_user.filled' => __('validation.user_level_max_token_required'),
            'max_token_send_to_same_user.integer' => __('validation.user_level_max_token_integer'),
        ];
    }
}
