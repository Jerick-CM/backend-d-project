<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
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
        $this->call(BlackTokenLogTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
        $this->call(InventoryTableSeeder::class);
        $this->call(SetInventoryStockSeeder::class);
        $this->call(BannerSeeder::class);
        $this->call(EdmSeeder::class);
        $this->call(ContactEmailsTableSeeder::class);
    }
}
