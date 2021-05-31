<?php

use App\Models\Badge;
use Illuminate\Database\Seeder;

class WorldClassFixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $badge = Badge::find(8);
        $badge->name = 'WorldClass Citizen';
        $badge->save();
    }
}
