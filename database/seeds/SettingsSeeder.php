<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('settings')->insert([
            'setting' => 'blockedDays',
            'data' => json_encode([
                'isMondayEnabled' => false,
                'isTuesdayEnabled' => false,
                'isWednesdayEnabled' => false,
                'isThursdayEnabled' => false,
                'isFridayEnabled' => true,
                'isSaturdayEnabled' => false,
                'isSundayEnabled' => false,
            ])
        ]);
    }
}
