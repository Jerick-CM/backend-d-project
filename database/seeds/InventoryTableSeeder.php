<?php

use App\Models\Inventory;
use App\Models\InventoryPhoto;
use Illuminate\Database\Seeder;

class InventoryTableSeeder extends Seeder
{
    protected $items;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->items = [
            [
                'name' => '13" Notebook',
                'file' => 'notebook.jpg',
            ],
            [
                'name' => 'External SSD',
                'file' => 'external.jpg',
            ],
            [
                'name' => 'LCD Monitor',
                'file' => 'monitor.jpg',
            ],
            [
                'name' => 'Headset',
                'file' => 'headset.png',
            ],
            [
                'name' => 'Bluetooth Speaker',
                'file' => 'speaker.png',
            ],
            [
                'name' => 'Smartphone',
                'file' => 'smartphone.jpg',
            ],
            [
                'name' => 'Keyboard',
                'file' => 'keyboard.jpg',
            ],
            [
                'name' => 'Mouse',
                'file' => 'mouse.png'
            ],
            [
                'name' => 'Mouse Pad',
                'file' => 'mousepad.jpg',
            ],
            [
                'name' => 'Flash Drive',
                'file' => 'flash.jpg',
            ],
            [
                'name' => 'Keychain',
                'file' => 'keychain.jpg',
            ],
            [
                'name' => 'USB Lampshade',
                'file' => 'lamp.jpg',
            ],
            [
                'name' => 'USB Webcam',
                'file' => 'webcam.jpg',
            ],
            [
                'name' => 'Gamepad',
                'file' => 'gamepad.jpg',
            ],
            [
                'name' => 'Android Tablet',
                'file' => 'tablet.png',
            ],
            [
                'name' => 'Backpack',
                'file' => 'backpack.jpg',
            ],
            [
                'name' => 'Laptop Table',
                'file' => 'laptop-table.jpg',
            ],
            [
                'name' => 'Computer Desk',
                'file' => 'pc-desk.jpg',
            ],
            [
                'name' => 'Gaming Chair',
                'file' => 'chair.jpg',
            ],
            [
                'name' => 'Driving Wheel Gamepad',
                'file' => 'driving-wheel.jpg',
            ],
        ];

        $this->create();
    }

    public function create()
    {
        foreach ($this->items as $item) {
            $inventory = Inventory::create([
                'name' => $item['name'],
                'unit_price' => 5 * (rand(2, 10)),
                'meta' => [],
            ]);

            InventoryPhoto::create([
                'inventory_id' => $inventory->id,
                'is_primary'   => 1,
                'file' => $item['file'],
            ]);
        }
    }
}
