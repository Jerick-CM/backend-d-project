<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BlackTokenLogEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $action;
    public $type;
    public $amount;
    public $remarks;
    public $created_by;
    public $expires_at;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user_id, $action, $type, $amount, $remarks, $created_by, $expires_at = null)
    {
        $this->user_id = $user_id;
        $this->action  = $action;
        $this->type    = $type;
        $this->amount  = $amount;
        $this->remarks = $remarks;
        $this->created_by = $created_by;
        $this->expires_at = $expires_at;
    }
}
