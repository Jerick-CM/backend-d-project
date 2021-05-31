<?php

use App\Models\Category;
use App\Models\Inventory;
use App\Models\InventoryPhoto;
use Illuminate\Database\Seeder;

class ProductionInventoryBrandedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'name' => '4 pieces of stainless steel straw set',
                'unit_price' => 6,
                'stock' => 200,
                'categories' => [
                    'Household',
                ],
                'images' => [
                    'default-branded-1-1.jpg',
                    'default-branded-1-2.jpg',
                ],
            ],
            [
                'name' => '3 Dial TSA Travel Lock',
                'unit_price' => 7,
                'stock' => 200,
                'categories' => [
                    'Travel Accessories',
                ],
                'images' => [
                    'default-branded-2-1.jpg',
                    'default-branded-2-2.jpg',
                ],
            ],
            [
                'name' => 'Waterproof dry bag',
                'unit_price' => 7,
                'stock' => 200,
                'categories' => [
                    'Sports Accessories',
                ],
                'images' => [
                    'default-branded-3-1.jpg',
                    'default-branded-3-2.jpg',
                ],
            ],
            [
                'name' => 'Customise ez-link card',
                'unit_price' => 8,
                'stock' => 200,
                'categories' => [
                    'Transport',
                ],
                'images' => [
                    'default-branded-4-1.jpg',
                    'default-branded-4-2.jpg',
                ],
            ],
            [
                'name' => 'Mini USB fan',
                'unit_price' => 9,
                'stock' => 200,
                'categories' => [
                    'Smart Tech',
                    'Household',
                ],
                'images' => [
                    'default-branded-5-1.jpg',
                    'default-branded-5-2.jpg',
                    'default-branded-5-3.jpg',
                ],
            ],
            [
                'name' => '6 in 1 travel packing cube',
                'unit_price' => 10,
                'stock' => 200,
                'categories' => [
                    'Travel Accessories',
                ],
                'images' => [
                    'default-branded-6-1.jpg',
                ],
            ],
            [
                'name' => '21 inch 3 fold auto open and close umbrella',
                'unit_price' => 10,
                'stock' => 200,
                'categories' => [
                    'Household',
                    'Health & Wellbeing',
                ],
                'images' => [
                    'default-branded-7-1.jpg',
                    'default-branded-7-2.jpg',
                    'default-branded-7-3.jpg',
                ],
            ],
            [
                'name' => 'Type C and 3 USB Port Travel Adaptor',
                'unit_price' => 22,
                'stock' => 200,
                'categories' => [
                    'Travel Accessories',
                    'Mobile Accessories',
                    'Smart Tech',
                ],
                'images' => [
                    'default-branded-8-1.png',
                ],
            ],
            [
                'name' => 'Qi wireless powerbank',
                'unit_price' => 25,
                'stock' => 200,
                'categories' => [
                    'Travel Accessories',
                    'Mobile Accessories',
                    'Smart Tech',
                ],
                'images' => [
                    'default-branded-9-1.jpg',
                    'default-branded-9-2.jpg',
                    'default-branded-9-3.jpg',
                ],
            ],
        ];

        $this->execute($items);
    }

    public function execute($data)
    {
        for ($i = 0; $i < count($data); $i++) {
            $inventoryData = collect($data[$i])->except('categories', 'images')->toArray();

            $inventory = Inventory::create($inventoryData);

            $photoIndex = 0;

            foreach ($data[$i]['images'] as $photo) {
                InventoryPhoto::create([
                    'inventory_id' => $inventory->id,
                    'is_primary'   => $photoIndex ? 0 : 1,
                    'file'         => $photo,
                ]);

                $photoIndex++;
            }

            foreach ($data[$i]['categories'] as $c) {
                $category = Category::firstOrCreate(['name' => $c]);
                $inventory->categories()->attach($category->id);
            }
        }
    }
}
