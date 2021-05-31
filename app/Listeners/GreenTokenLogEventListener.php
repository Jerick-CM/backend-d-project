<?php

namespace App\Listeners;

use App\Events\GreenTokenLogEvent;
use App\Models\GreenTokenLog;
use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GreenTokenLogEventListener
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
     * @param  GreenTokenLogEvent  $event
     * @return void
     */
    public function handle(GreenTokenLogEvent $event)
    {
        if ($event->action == GreenTokenLog::ACTION_CREDIT) {
            User::where('id', $event->user_id)->increment('green_token', $event->amount);
        } else {
            User::where('id', $event->user_id)->decrement('green_token', abs($event->amount));
        }
    
        GreenTokenLog::create([
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
