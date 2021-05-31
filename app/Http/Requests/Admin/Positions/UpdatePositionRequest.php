<?php

namespace App\Http\Requests\Admin\Positions;

use Takaworx\Brix\Http\Requests\BaseFormRequest;

class UpdatePositionRequest extends BaseFormRequest
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
            'positions' => 'required|array',
            'positions.*.id' => 'required|integer',
            'positions.*.monthly_token_allocation' => 'required|integer',
            'positions.*.max_token_send_to_same_user' => 'required|integer',
        ];
    }
}
