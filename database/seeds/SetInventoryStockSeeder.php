<?php

use App\Models\Inventory;
use Illuminate\Database\Seeder;

class SetInventoryStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $preorderIds = [
            1,
            3,
            6,
            15,
            19,
            20,
        ];

        $inventoryItems = Inventory::all();

        foreach ($inventoryItems as $ii) {
            if (in_array($ii->id, $preorderIds)) {
                $ii->is_preorder = 1;
            }
            
            $ii->stock = 8;
            $ii->save();
        }
    }
}
