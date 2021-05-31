<?php

namespace App\Listeners;

use App\Events\BlackTokenLogEvent;
use App\Models\BlackTokenLog;
use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BlackTokenLogEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BlackTokenLogEvent  $event
     * @return void
     */
    public function handle(BlackTokenLogEvent $event)
    {
        if ($event->action == BlackTokenLog::ACTION_CREDIT) {
            User::where('id', $event->user_id)->increment('black_token', $event->amount);
        } else {
            User::where('id', $event->user_id)->decrement('black_token', abs($event->amount));
        }

        BlackTokenLog::create([
            'user_id' => $event->user_id,
            'action'  => $event->action,
            'type'    => $event->type,
            'amount'  => $event->amount,
            'remarks' => $event->remarks,
            'created_by' => $event->created_by,
            'expires_at' => $event->expires_at,
        ]);
    }
}
