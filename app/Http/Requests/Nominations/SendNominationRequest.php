<?php

namespace App\Http\Requests\Nominations;

use App\Models\User;
use App\Models\MessageToken;
use Carbon\Carbon;
use Takaworx\Brix\Http\Requests\BaseFormRequest;

class SendNominationRequest extends BaseFormRequest
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


        $insufficientblacktoken = function ($attr, $value, $fail) {

            if ($this->user()->black_token < $this->input('credits')) {

                $fail(__('nomination.black_token.insufficient'));
                return false;

            }

            return true;
        };                

        $filterProfanities = function ($attr, $value, $fail) {

            if (! $this->filled('message')) {
                return true;
            }

            $badWords = config('profanity.defaults');

            foreach ($badWords as $badWord) {
                if (preg_match("~\b$badWord\b~", $this->input('message'))) {
                    $fail(__('validation.profanity'));
                    return false;
                }
            }

            return true;
        };

        $noTokenForPartner = function ($attr, $value, $fail) {
            $recipient = User::find($value);

            if ($recipient->is_partner && $this->input('credits') > 0) {
                $fail("You cannot send tokens to partners!");
                return false;
            }

            return true;
        };

        $maxSendCheck = function ($attr, $value, $fail) {
            
            $user = $this->user();

            $recipient = User::find($value);

            $dateFrom = Carbon::now()->startOfMonth()->hour(0)->minute(0)->second(0)->toDateTimeString();

            $dateUntil = Carbon::now()->endOfMonth()->hour(23)->minute(59)->second(59)->toDateTimeString();

            $sentTokens = MessageToken::where('sender_user_id', $user->id)
                ->where('amount', '>', 0)
                ->where('recipient_user_id', $value)
                ->where('created_at', '>=', $dateFrom)
                ->where('created_at', '<=', $dateUntil)
                ->get();


            // Tempo remove
            if (count($sentTokens) >= 2 && $this->input('credits') > 0) {
                $fail(__('validation.max_token_send_count', ['name' => $recipient->name]));
                return false;
            }

            if (is_null($user->userLevel)) {
                return true;
            }

            $maxTotal = $user->userLevel->max_token_send_to_same_user;

            if ($this->input('credits') > $maxTotal) {
                $fail(__('validation.max_token_send_amount', ['name' => $recipient->name]));
                return false;
            }

            return true;
        };

        return [
            'id'       => [
                'required',
                'int',
                $maxSendCheck,
                $noTokenForPartner,
                $insufficientblacktoken

            ],
            'badge_id' => 'required|exists:badges,id',
            'credits'  => 'integer',
            'message'  => [
                'max:256',
                $filterProfanities,
            ],
        ];



    }
}
