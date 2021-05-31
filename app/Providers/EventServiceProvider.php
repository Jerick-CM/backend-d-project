<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // 'App\Events\Event' => [
        //     'App\Listeners\EventListener',
        // ],
        'App\Events\GreenTokenLogEvent' => [
            'App\Listeners\GreenTokenLogEventListener',
        ],
        'App\Events\UserAccessEvent' => [
            'App\Listeners\UserAccessEventListener',
        ],
        'App\Events\BlackTokenLogEvent' => [
            'App\Listeners\BlackTokenLogEventListener',
        ],
        'App\Events\AdminLogEvent' => [
            'App\Listeners\AdminLogEventListener',
        ],
        'SocialiteProviders\Manager\SocialiteWasCalled' => [
            'SocialiteProviders\Graph\GraphExtendSocialite@handle',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
