<?php

namespace App\Console\Commands;

use App\Models\BlackTokenLog;
use App\Models\GreenTokenLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AuditTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tokens:audit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Audit tokens for inconsistencies and correction';

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
        $users = User::all();

        foreach ($users as $user) {
            $this->auditUserBlackToken($user);
            $this->auditUserGreenToken($user);
        }
    }

    protected function auditUserBlackToken($user)
    {
        $user_id = $user->id;
        
        $blackTokenLogs = BlackTokenLog::where('user_id', $user_id)->get();

        $blackTokens = $blackTokenLogs->sum('amount');

        if ($user->black_token != $blackTokens) {
            $msg = "User({$user->id}) inconsistent black token. Has({$user->black_token}) Should Have({$blackTokens})";
            \Log::error($msg);
            $user->black_token = $blackTokens;
            $user->save();
            /** @todo send email to report inconsistency */
        }
    }

    protected function auditUserGreenToken($user)
    {
        $user_id = $user->id;

        $greenTokenLogs = GreenTokenLog::where('user_id', $user_id)
            ->where(function ($query) {
                $query->where('action', GreenTokenLog::ACTION_DEBIT)
                      ->orWhere(function ($queryB) {
                          $queryB->where('action', GreenTokenLog::ACTION_CREDIT)
                                 ->where('expires_at', '>', Carbon::now()->toDateString());
                      });
            });

        $greenTokens = $greenTokenLogs->sum('amount');

        if ($greenTokens < 0) {
            $greenTokens = 0;
        }
        
        if ($user->green_token != $greenTokens) {
            $msg = "User({$user->id}) inconsistent green token. Has({$user->green_token}) Should Have({$greenTokens})";
            \Log::error($msg);
            $user->green_token = $greenTokens;
            $user->save();
            /** @todo send email to report inconsistency */
        }
    }
}
