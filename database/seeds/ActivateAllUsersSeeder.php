<?php

use Illuminate\Database\Seeder;

class ActivateAllUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->update([
            'is_active' => 1,
        ]);
    }
}
