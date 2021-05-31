<?php

use App\Models\UserLevel;
use Illuminate\Database\Seeder;

class CareerLevelTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $uls = UserLevel::get();

        foreach ($uls as $ul) {
            $ul->monthly_token_allocation = 100;
            $ul->max_token_send_to_same_user = 100;
            $ul->save();
        }
    }
}
