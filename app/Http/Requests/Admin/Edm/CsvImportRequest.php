<?php

namespace App\Http\Requests\Admin\Edm;

use Takaworx\Brix\Http\Requests\BaseFormRequest;

class CsvImportRequest extends BaseFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'csv_masstokenupload' => 'required|file'
        ];
    }
}
