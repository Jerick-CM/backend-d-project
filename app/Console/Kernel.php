<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Send 10 black tokens to newly synced users. Set CRON_SEND_WELCOME=true to enable.
        if (config('cron.send_welcome')) {
            $schedule->command('tokens:send_welcome')->hourly();
        }

        // Synchronize users from azure every 30 minutes. Set CRON_SYNC_USERS=true to enable.
        if (config('cron.sync_users')) {
            $schedule->command('azure:sync')->daily()->withoutOverlapping();
        }

        // Send black tokens monthly according to user level. Set CRON_SEND_BLACK_TOKENS_QUARTERLY=true to enable.
        if (config('cron.tokens.distribute')) {
            $schedule->command('tokens:distribute')->quarterly();
        }

        // Check inconsistencies in user tokens daily and forcibly correct. Set CRON_AUDIT_TOKENS_DAILY=true to enable.
        if (config('cron.tokens.audit')) {
            $schedule->command('tokens:audit')->daily();
        }

        if (config('cron.tokens.test')) {
            $schedule->command('tokens:send')->everyFifteenMinutes();
        }

        if (config('cron.send_monthly_summary')) {
            // Send monthly token summary to users every month.
            $schedule->command('report:monthly_summary')->daily()->when(function () {
                return Carbon::now()->endOfMonth()->isToday();
            });
        }
        if (config('cron.tokens.expiredaily')) {
            $schedule->command('tokens:expire')->daily();
        }

        if (config('cron.tokens.expiremonthly')) {
            $schedule->command('tokens:expire')->monthly();
        }
        // Check for expired tokens everyday.
        $schedule->command('tokens:prune')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
