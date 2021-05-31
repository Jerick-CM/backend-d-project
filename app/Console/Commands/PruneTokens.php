<?php

namespace App\Console\Commands;

use App\Models\GreenTokenLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PruneTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tokens:prune';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune expired tokens';

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
        $now = Carbon::now()->toDateTimeString();

        $logs = GreenTokenLog::where('is_pruned', 0)
            ->where('expires_at', '<=', $now)
            ->get();

        foreach ($logs as $log) {
            $this->prune($log->user_id, $log->id, $log->amount);
        }
    }

    protected function prune($user_id, $log_id, $amount)
    {
        DB::transaction(function () use ($user_id, $log_id, $amount) {
            User::where('id', $user_id)
                ->decrement('green_token', $amount);
            
            GreenTokenLog::where('id', $log_id)
                ->update([
                    'is_pruned' => 1
                ]);
        });
    }
}
