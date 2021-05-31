<?php

namespace App\Listeners;

use App\Events\UserAccessEvent;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserAccessEventListener
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
     * @param  UserAccessEvent  $event
     * @return void
     */
    public function handle(UserAccessEvent $event)
    {

        return  $event->azure_id;
        exit();
        UserRepository::search(
            'azure_id', $event->azure_id
            //'azure_id' => $event->azure_id,
            // 'name' => $event->name,
            // 'department_name' => $event->department_name,
            // 'position_name' => $event->position_name,
            // 'career_level' => $event->career_level,
            // 'is_active' => $event->is_active,
            // 'is_admin' => $event->is_admin,
        );
    }
}
