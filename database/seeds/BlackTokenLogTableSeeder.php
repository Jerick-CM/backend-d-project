<?php

use App\Models\User;
use App\Models\BlackTokenLog;
use App\Repositories\BlackTokenLogRepository;
use Illuminate\Database\Seeder;

class BlackTokenLogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $repo = new BlackTokenLogRepository();

        $users = User::all();

        $amount = ((count($users) - 1) * 10) + 100;

        foreach ($users as $user) {
            $repo->send([
                'user_id' => $user->id,
                'action'  => BlackTokenLog::ACTION_CREDIT,
                'amount'  => $amount,
            ]);
        }
    }
}
