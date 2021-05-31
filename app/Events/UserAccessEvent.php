<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserAccessEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $id;
    public $name;
    public $department_name;
    public $position_name;
    public $career_level;
    public $is_active;
    public $is_admin;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    /*public function __construct($id, $name, $department_name, $position_name, $career_level, $is_active, $is_admin)
    {
        //
        $this->id = $id;
        $this->name = $name;
        $this->department_name = $department_name;
        $this->position_name = $position_name;
        $this->career_level = $career_level;
        $this->is_active = $is_active;
        $this->is_admin = $is_admin;
    }*/

    public function __construct($azure_id)
    {
        //
        $this->azure_id = $azure_id;
        //$this->id = $id;
        // $this->name = $name;
        // $this->department_name = $department_name;
        // $this->position_name = $position_name;
        // $this->career_level = $career_level;
        // $this->is_active = $is_active;
        // $this->is_admin = $is_admin;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    
     public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
    
}
