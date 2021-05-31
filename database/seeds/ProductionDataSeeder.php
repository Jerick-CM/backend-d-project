<?php

use Illuminate\Database\Seeder;

class ProductionDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BadgesTableSeeder::class);
        $this->call(ProfanitiesTableSeeder::class);
        $this->call(ContactEmailProdSeeder::class);
        $this->call(EdmProdSeeder::class);
        $this->call(SetAdminUserSeeder::class);
        $this->call(ProductionInventorySeeder::class);
        $this->call(ProductionUserLevelSeeder::class);
        $this->call(ProductionInventoryBrandedSeeder::class);
    }
}
