<?php

namespace App\Console\Commands;

use App\Models\BlackTokenLog;
use App\Models\User;
use App\Repositories\BlackTokenLogRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendBlackTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tokens:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send 10 tokens to all users. For TESTING PURPOSES ONLY!';

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
        $users = User::get();

        foreach ($users as $user) {
            $this->sendTokenToUser($user);
        }
    }

    protected function sendTokenToUser($user)
    {
        DB::transaction(function () use ($user) {
            $repo = new BlackTokenLogRepository();

            $amount = 10;

            $blackTokenLog = $repo->send([
                'user_id' => $user->id,
                'action'  => BlackTokenLog::ACTION_CREDIT,
                'amount'  => $amount,
            ]);
        });
    }
}
