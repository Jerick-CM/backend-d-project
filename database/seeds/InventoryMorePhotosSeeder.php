<?php

use App\Models\InventoryPhoto;
use Illuminate\Database\Seeder;

class InventoryMorePhotosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $flash = [
            'flash2.jpg',
            'flash3.jpg',
            'flash4.jpg',
            'flash5.jpg',
        ];

        $notebook = [
            'notebook2.jpg',
            'notebook3.jpg',
            'notebook4.jpg',
            'notebook5.jpg',
        ];

        $this->execute(10, $flash);
        $this->execute(1, $notebook);
    }

    public function execute($inventory_id, $array) {
        foreach ($array as $file) {
            $data['inventory_id'] = $inventory_id;
            $data['is_primary'] = 0;
            $data['file'] = $file;

            InventoryPhoto::create($data);
        }
    }
}
