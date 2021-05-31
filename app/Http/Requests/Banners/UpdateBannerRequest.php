<?php

namespace App\Http\Requests\Banners;

use App\Models\Banner;
use Takaworx\Brix\Http\Requests\BaseFormRequest;

class UpdateBannerRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $bannerID = $this->route('banner_id');

        $exists = Banner::where('id', $bannerID)->count();

        if (! $exists) {
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
            'title'  => 'filled',
            'photo'  => 'filled|file',
            'is_open_in_new_tab' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'title.filled' => __('validation.banner_title_required'),
            'photo.filled' => __('validation.banner_file_required'),
            'photo.file' => __('validation.banner_file_invalid'),
        ];
    }
}
