<?php

use App\Models\UserLevel;
use Illuminate\Database\Seeder;

class ProductionUserLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $levels = UserLevel::get();

        if (! $levels) {
            return;
        }

        foreach ($levels as $level) {
            switch ($level->career_level) {
                case 1:
                case 2:
                    $level->monthly_token_allocation = 25;
                    $level->max_token_send_to_same_user = 10;
                    break;
                case 3:
                case 4:
                case 5:
                    $level->monthly_token_allocation = 50;
                    $level->max_token_send_to_same_user = 10;
                    break;
                case 6:
                case 7:
                case 8:
                    $level->monthly_token_allocation = 70;
                    $level->max_token_send_to_same_user = 15;
                    break;
                case 9:
                    $level->monthly_token_allocation = 125;
                    $level->max_token_send_to_same_user = 25;
                    break;
            }

            $level->save();
        }
    }
}
