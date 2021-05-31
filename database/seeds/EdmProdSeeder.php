<?php

use Illuminate\Database\Seeder;

class EdmProdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EdmSeeder::class);
        $this->call(EdmNameUpdateSeeder::class);
        $this->call(EdmFileWelcomeSeeder::class);
        $this->call(EdmFinalSeeder::class);
        $this->call(EdmMonthlySummarySeeder::class);
        $this->call(EdmFinalNamesSeeder::class);
    }
}
