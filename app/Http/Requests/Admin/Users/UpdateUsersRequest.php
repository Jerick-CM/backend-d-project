<?php

namespace App\Http\Requests\Admin\Users;

use Takaworx\Brix\Http\Requests\BaseFormRequest;

class UpdateUsersRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (! $this->user()->is_admin) {
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
            'users' => 'required|array',
            'users.*.id' => 'required|integer',
            'users.*.is_active' => 'filled|integer',
            'users.*.is_admin'  => 'filled|integer',
            'users.*.green_token' => 'filled|integer',
            'users.*.remarks' => 'required_with:users.*.green_token',
        ];
    }
}
