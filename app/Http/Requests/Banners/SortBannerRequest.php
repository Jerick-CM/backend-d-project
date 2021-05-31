<?php

namespace App\Http\Requests\Banners;

use Takaworx\Brix\Http\Requests\BaseFormRequest;

class SortBannerRequest extends BaseFormRequest
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
            'banners' => 'required|array',
            'banners.*.id' => 'required|int',
            'banners.*.order' => 'required|int',
        ];
    }
}
