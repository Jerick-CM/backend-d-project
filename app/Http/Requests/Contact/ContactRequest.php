<?php

namespace App\Http\Requests\Contact;

use Takaworx\Brix\Http\Requests\BaseFormRequest;

class ContactRequest extends BaseFormRequest
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
            'type' => 'required|int',
            'name' => 'required',
            'email' => 'required|email',
            'department' => 'required',
            'designation' => 'required',
            'message' => 'required',
            'no_reply' => 'boolean',
            'attachment' => 'file',
        ];
    }

    public function messages()
    {
        return [
            'message.required' => __('validation.contact_message_required'),
        ];
    }
}
