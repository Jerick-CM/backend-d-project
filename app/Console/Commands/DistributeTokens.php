<?php

namespace App\Console\Commands;

use App\Models\BlackTokenLog;
use App\Models\User;
use App\Models\UserLevel;
use App\Repositories\BlackTokenLogRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DistributeTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tokens:distribute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Distribute black tokens to users';

    /**
     * Array of user levels
     *
     * @var array
     */
    protected $user_levels;

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
        $this->user_levels = UserLevel::get();

        $users = User::where('is_active', 1)->get();

        foreach ($users as $user) {
            $this->distributeTokenToUser($user);
        }
    }

    protected function distributeTokenToUser($user)
    {
        $result = DB::transaction(function () use ($user) {
            $repo = new BlackTokenLogRepository();

            $careerLevelExists = $this->user_levels->where('career_level', $user->career_level)->count();

            if (! $careerLevelExists) {
                throw new \Exception("The user's (id: {$user->id}) career level does not exist!");
            }

            $userLevel = $this->user_levels->firstWhere('career_level', $user->career_level);

            $amount = $userLevel->monthly_token_allocation - $user->black_token;

            // Skip if user does not need replenishing of black tokens
            if ($amount <= 0) {
                return false;
            }

            $blackTokenLog = $repo->send([
                'user_id' => $user->id,
                'action'  => BlackTokenLog::ACTION_CREDIT,
                'amount'  => $amount,
            ]);
        });

        if ($result instanceof \Exception) {
            /** @todo send email if script failed */
        }

        return true;
    }
}
