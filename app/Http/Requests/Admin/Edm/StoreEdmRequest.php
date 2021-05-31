<?php

namespace App\Http\Requests\Admin\Edm;

use Takaworx\Brix\Http\Requests\BaseFormRequest;

class StoreEdmRequest extends BaseFormRequest
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
            'id'   => 'required|int',
            'file' => 'required|file',
        ];
    }
}
