<?php

namespace App\Http\Requests\Nominations;

use App\Models\Message;
use Takaworx\Brix\Http\Requests\BaseFormRequest;

class LikeNominationRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $message_id = $this->route('nomination_id');

        $message = Message::find($message_id);

        if (! $message) {
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
        return [];
    }
}
