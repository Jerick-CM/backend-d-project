<?php

use Illuminate\Database\Seeder;

class ServiceLineAndCareerLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ServiceLineTableSeeder::class);
        $this->call(CareerLevelSeeder::class);
        $this->call(CareerLevelTokenSeeder::class);
    }
}
