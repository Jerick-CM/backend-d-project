<?php

namespace App\Console\Commands;

use App\Events\GreenTokenLogEvent;
use App\Models\User;
use App\Models\GreenTokenLog;
use App\Mail\WelcomeMail;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendWelcomeTokens extends Command
{
    const WELCOME_TOKEN_AMOUNT = 10;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tokens:send_welcome';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send welcome tokens';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::where('is_active', 1)
            ->where('has_received_welcome_tokens', 0)
            ->get();

        $date   = Carbon::now()->format('d F Y');
        $tokens = config('cron.send_welcome_amount');

        foreach ($users as $user) {
            $is_sent = $this->sendToUser($user, $tokens);

            if ($is_sent === true && config('cron.send_welcome_email')) {
                Mail::to($user->email)->send(new WelcomeMail($user, $tokens, $date,false,false,''));
            }
        }
    }

    /**
     * Send the welcome token to a single user
     */
    protected function sendToUser($user, $amount)
    {
        try {
            DB::beginTransaction();

            event(new GreenTokenLogEvent(
                $user->id,
                GreenTokenLog::ACTION_CREDIT,
                GreenTokenLog::TYPE_ADMIN_OVERRIDE,
                $amount,
                "Welcome token",
                $user->id
            ));

            User::where('id', $user->id)->update([
                'has_received_welcome_tokens' => true,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

        return true;
    }
}
