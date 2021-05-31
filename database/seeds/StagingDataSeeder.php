<?php

use Illuminate\Database\Seeder;

class StagingDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategorySeeder::class);
        $this->call(BlackTokenLogTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
        $this->call(InventoryTableSeeder::class);
        $this->call(SetInventoryStockSeeder::class);
        $this->call(InventoryDataSeeder::class);
        $this->call(InventoryMorePhotosSeeder::class);
    }
}
