<?php

namespace App\Http\Controllers;

use App\Mail\MonthlySummaryMail;
use App\Mail\NominationRecipientMail;
use App\Mail\NominationSenderMail;
use App\Mail\RedeemMail;
use App\Mail\WelcomeMail;
use App\Models\EdmLog;
use Illuminate\Http\Request;
use Takaworx\Brix\Entities\ApiResponse;
use Takaworx\Brix\Exceptions\ApiException;

class MailController extends BaseEdmController
{
    public function index($uid)
    {
        $edmLog = EdmLog::where('uid', $uid)->first();

        if (! $edmLog) {
            return ApiResponse::exception(ApiException::notFound());
        }

        $data = $edmLog->data;

        switch ($edmLog->type) {
            case 1:
            case 5:
                $content = new NominationSenderMail(
                    $data->user,
                    $data->recipient,
                    $data->message,
                    $data->badge,
                    $data->token,
                    $data->date,
                    $data->time,
                    true,
                    $editpreview = false,
                    $content = ''

                );
                break;
            case 2:
            case 6:
                $content = new NominationRecipientMail(
                    $data->user,
                    $data->sender,
                    $data->message,
                    $data->badge,
                    $data->token,
                    $data->date,
                    $data->time,
                    true,
                    $editpreview = false,
                    $content = ''
                );
                break;
            case 3:
                $orderItems = [];

                foreach ($data->orderItems as $oi) {
                    $orderItems[] = [
                        'inventory' => $oi->inventory,
                        'tokens' => $oi->tokens,
                        'quantity' => $oi->quantity,
                    ];
                }

                $content = new RedeemMail(
                    $data->user,
                    $orderItems,
                    $data->totalTokens,
                    $data->orderNumber,
                    $data->date,
                    $data->orderDate,
                    $data->collectionDate,
                    true
                );
                break;
            case 4:
                $content = new WelcomeMail($data->user, $data->numberOfToken, $data->date, true,false,'');
                break;
            case 7:
                $content = new MonthlySummaryMail($data->user, true);
                break;
        }

        return $content;
    }
}
