<?php

namespace App\Http\Requests\Banners;

use Takaworx\Brix\Http\Requests\BaseFormRequest;

class StoreBannerRequest extends BaseFormRequest
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
            'title'  => 'required',
            'photo'  => 'required|file',
            'type'   => 'integer|in:0,1',
            'is_open_in_new_tab' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('validation.banner_title_required'),
            'photo.required' => __('validation.banner_file_required'),
            'photo.file' => __('validation.banner_file_invalid'),
        ];
    }
}
