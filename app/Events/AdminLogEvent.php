<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AdminLogEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $type;
    public $meta;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user_id, $type, $meta)
    {
        $this->user_id = $user_id;
        $this->type = $type;
        $this->meta = $meta;
    }
}
