<?php

namespace App\Http\Requests\Admin\Inventory;

use Takaworx\Brix\Http\Requests\BaseFormRequest;

class PhotoSortRequest extends BaseFormRequest
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
            'photos' => 'required|array',
            'photos.*.id' => 'required|integer',
            'photos.*.order' => 'required|integer',
        ];
    }
}
