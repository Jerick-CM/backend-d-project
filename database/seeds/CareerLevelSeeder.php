<?php

use App\Models\User;
use App\Models\UserLevel;
use Illuminate\Database\Seeder;

class CareerLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::get();

        $x = 1;

        foreach ($users as $user) {
            $user->career_level = $x;
            $user->save();

            UserLevel::firstOrCreate([
                'career_level' => $x,
            ]);

            $x++;
        }
    }
}
