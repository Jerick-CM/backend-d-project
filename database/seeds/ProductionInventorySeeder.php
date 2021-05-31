<?php

use App\Models\Category;
use App\Models\Inventory;
use App\Models\InventoryPhoto;
use Illuminate\Database\Seeder;

use function PHPSTORM_META\map;

class ProductionInventorySeeder extends Seeder
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
                'name' => 'Braun HD380 Satin Hair 3 Hair Dryer',
                'unit_price' => 70,
                'stock' => 5,
                'meta' => [
                    'Brand' => 'Braun',
                    'Product Height/Width/Depth(cm)' => '28.5/19.6/10',
                ],
                'categories' => [
                    'Beauty Gadgets',
                    'Smart Tech',
                    'Household',
                ]
            ],
            [
                'name' => 'HP Y5H68A 2621 All-in-One Deskjet Printer',
                'unit_price' => 80,
                'stock' => 5,
                'meta' => [
                    'Model' => 'Y5H68A',
                    'Max Paper Size' => '89 x 127 to 215 x 279mm',
                    'Max Print Resolution' => '600 x 300',
                    'Print Speed B&W' => '20 ppm',
                    'Print Speed Colour' => '5.5 ppm',
                ],
                'categories' => [
                    'Smart Tech',
                    'Digital',
                    'Stationery',
                ]
            ],
            [
                'name' => 'Fujifilm Instax Mini 9 Shibuya Package Kit - Smokey White',
                'unit_price' => 150,
                'stock' => 5,
                'meta' => [
                    'Product Height/Width/Dept' => '11.83cm/11.6cm/6.82cm',
                ],
                'categories' => [
                    'Smart Tech',
                    'Cameras',
                    'Digital',
                ]
            ],
            [
                'name' => 'WD My Passport External Storage - 4TB Black',
                'unit_price' => 170,
                'stock' => 5,
                'meta' => [
                    'Model' => 'BYFT0040BBK',
                    'Product Type' => 'Portable External Drive',
                    'Product Height/Width/Depth' => '2.15cm/11cm/8.15cm',
                ],
                'categories' => [
                    'Computing',
                    'Smart Tech',
                    'Digital',
                    'Computing',
                ]
            ],
            [
                'name' => 'Novita EM200 Eye & Temple Massager',
                'unit_price' => 200,
                'stock' => 5,
                'meta' => [
                    'Model' => 'EM200',
                    'Product Type' => 'Eye Massenger',
                    'Product Height/Width/Depth' => ' 9cm/21cm/8.5cm ',
                ],
                'categories' => [
                    'Health & Wellbeing',
                    'Smart Tech',
                ]
            ],
            [
                'name' => 'Philips HP8372/03 Straightener and HP4585/00 Ionic Styling Brush',
                'unit_price' => 200,
                'stock' => 5,
                'meta' => [
                    'Model' => 'HP8372/03 + HP4585/00',
                    'Product Type' => 'Hair Straighteners',
                    'Weight' => '0.4kg',
                ],
                'categories' => [
                    'Beauty Gadgets',
                    'Smart Tech',
                    'Household',
                ]
            ],
            [
                'name' => 'Sony WF-1000X Wireless Noise-Cancelling In-Ear Headphones',
                'unit_price' => 300,
                'stock' => 5,
                'meta' => [
                    'Model' => 'HP8372/03 and HP4585/00',
                    'Product Type' => 'Earbuds',
                    'Bluetooth' => 'Bluetooth 4.1',
                    'Weight' => '0.090kg',
                ],
                'categories' => [
                    'Smart Tech',
                    'Sports Equipment',
                    'Mobile Accessories',
                ]
            ],
            [
                'name' => 'NOVITA MC108 Massager Back Chair - Space Grey',
                'unit_price' => 300,
                'stock' => 5,
                'meta' => [
                    'Model' => 'MC108 Space Grey',
                    'Product Type' => 'Massage Chairs',
                    'Product Height/Width/Depth' => '78cm/140cm/44.5cm',
                    'Weight' => '7kg',
                ],
                'categories' => [
                    'Health & Wellbeing',
                    'Smart Tech',
                ]
            ],
            [
                'name' => 'Philips HR1889/71 Masticating Juicer',
                'unit_price' => 349,
                'stock' => 5,
                'meta' => [
                    'Model' => 'HR1889/71',
                    'Product Type' => 'Juicers',
                    'Product Length/Height/Width' => '36.1cm/36cm/13.6cm',
                    'Weight' => '4.4kg',
                ],
                'categories' => [
                    'Smart Tech',
                    'Household',
                ]
            ],
            [
                'name' => 'Nikon Coolpix B500 Ditgital Camera - black',
                'unit_price' => 360,
                'stock' => 5,
                'meta' => [
                    'Resolution' => '16MP Low-light CMOS Sensor',
                    'Lens' => '40x Zoom-NIKKOR ED Glass Lens',
                    'Screen' => '3" 921,000-dot Tilt LCD',
                ],
                'categories' => [
                    'Smart Tech',
                    'Cameras',
                    'Digital',
                ]
            ],
            [
                'name' => 'Fujifilm Instax Share SP-3 Smartphone Printer - White',
                'unit_price' => 400,
                'stock' => 5,
                'meta' => [
                    'Model' => 'Instax Share SP-3',
                    'Product Type' => 'Photo Printer',
                    'Product Height/Width/Depth' => '13.05cm/11.6cm/4.44cm',
                    'Weight' => '0.312kg',
                ],
                'categories' => [
                    'Smart Tech',
                    'Computing Digital',
                    'Stationery', 
                ]
            ],
            [
                'name' => 'JBL Xtreme 2 Portable Bluetooth Speaker',
                'unit_price' => 400,
                'stock' => 5,
                'meta' => [
                    'Model' => 'Xtreme 2',
                    'Product Type' => 'Portable Speakers',
                    'Connectivity' => 'Bluetooth 4.2',
                    'Product Height/Width/Depth' => '13.6cm/28.8cm/13.2cm',
                    'Weight' => '2.393kg',
                    'Estimated Battery Life' => 'Up to 15H',
                    'Total Output Power (RMS)' => '2 x 20W',
                    'Frequency Response (HZ)' => '55-20.000Hz',
                ],
                'categories' => [
                    'Smart Tech',
                    'Digital',
                    'Mobile Accessories',
                ]
            ],
            [
                'name' => 'Garmin Vivoactive 3 Smartwatch - Black & Stainless Steel',
                'unit_price' => 410,
                'stock' => 5,
                'meta' => [
                    'Model' => 'Vivoactive 3 Black & Stainless Steel',
                    'Product Type' => 'Smartwatches',
                    'Connectivity' => 'Bluetooth',
                    'Product Height/Width/Depth' => '1.17cm/4.34cm/4.34cm',
                    'Weight' => '0.043kg',
                    'Battery Life' => 'Up to 7 days',
                ],
                'categories' => [
                    'Smart Tech',
                    'Sports Accessories',
                ]
            ],
            [
                'name' => 'Beats Studio 3 Wireless Bluetooth Headphones',
                'unit_price' => 480,
                'stock' => 5,
                'meta' => [
                    'Product Type' => 'Wireless Headphones',
                    'Product Height' => '18.4cm',
                    'Weight' => '260g',
                    'Estimated Battery Life' => 'Up to 22hours of battery life with pure ANC on and 40hours with pure ANC off',
                    'Fast Fuel' => '10 minute charge provides 3hours of playback',
                ],
                'categories' => [
                    'Smart Tech',
                    'Sports Accessories',
                    'Mobile Accessories',
                ]
            ],
            [
                'name' => 'Apple iPad 9.7" 6th Generation Wi-Fi 32GB',
                'unit_price' => 500,
                'stock' => 5,
                'meta' => [
                    'Product Height/Width/Depth' => '9.4inches/6.6inches/0.29inch',
                    'Weight' => '469g',
                ],
                'categories' => [
                    'Computing',
                    'Smart Tech',
                    'Digital',
                    'Computing',
                ]
            ],
            [
                'name' => 'Samsung Galaxy Tab A T515 10.1" (3GB RAM + 32GB) LTE Tablet - Black',
                'unit_price' => 500,
                'stock' => 5,
                'meta' => [
                    'Model' => 'Galaxy Tab A T515 (LTE)',
                    'Product Type' => 'Tablets',
                    'Product Height/Width/Depth' => '24.53cm/14.94cm/0.75cm',
                    'Weight' => '0.469kg',
                    'Bluetooth' => ' Bluetooth: Bluetooth: 5.0',
                    'Hard Drive Size (GB)' => '32',
                ],
                'categories' => [
                    'Computing',
                    'Smart Tech',
                    'Digital',
                ]
            ],
            [
                'name' => 'Fujifilm SQ10 Instax Square Hybrid Instant Camera',
                'unit_price' => 500,
                'stock' => 5,
                'meta' => [
                    'Model' => 'SQ10',
                    'Product Type' => 'Instant Camera',
                    'Product Height/Width/Depth' => '12.7cm/11.9cm/4.7cm',
                    'Weight' => '0.450kg',
                    'USB' => '1 X Micro USB',
                ],
                'categories' => [
                    'Smart Tech',
                    'Cameras',
                    'Digital',
                ]
            ],
            [
                'name' => 'Nintendo Asia Switch Console - Neon Red/Blue',
                'unit_price' => 500,
                'stock' => 5,
                'meta' => [
                    'Battery Life' => '4.5h to 9h',
                ],
                'categories' => [
                    'Smart Tech',
                    'Computer & Game',
                    'Digital', 
                ]
            ],
            [
                'name' => 'GoPro Hero 7 Action Camera - Black',
                'unit_price' => 600,
                'stock' => 5,
                'meta' => [
                    'Model' => 'Hero 7',
                    'Product Type' => 'Action Cameras',
                    'Consist of' => 'HyperSmooth Video Stabilization, SuperPhoto Auto HDR Photo Enhancement, Voice Control and Raw Photos, Ability to capture 12MP Photos at up to 30fps and record 4K60, 2.7K120, and 1080p240 Video',
                ],
                'categories' => [
                    'Smart Tech',
                    'Digital',
                    'Travel Accessories',
                    'Cameras',
                ]
            ],
            [
                'name' => 'Samsung Galaxy Tab A (T595) 10.5" (3GB RAM + 32GB ROM) LTE Tablet',
                'unit_price' => 600,
                'stock' => 5,
                'meta' => [
                    'Model' => 'Galaxy Tab A T595 LTE',
                    'Product Type' => 'Tablets',
                    'Product Height/Width/Depth' => '26cm/16.11cm/0.8cm',
                    'Weight' => '0.53kg',
                    'Battery life' => 'Up to 15h',
                ],
                'categories' => [
                    'Computing',
                    'Smart Tech',
                    'Digital',
                    'Computing',
                ]
            ],
            [
                'name' => 'Dyson Supersonic HD01 Hair Dryer - Black/Nickel',
                'unit_price' => 600,
                'stock' => 5,
                'meta' => [
                    'Model' => 'Dyson Supersoic HD01 Black-Nickel',
                    'Product Height/Width/Length' => '9.6in/3.1in/3.8in',
                    'Weight' => '1.8lbs',
                    'Air Flow' => '41 I/s',
                    'Power' => '1600W',
                ],
                'categories' => [
                    'Beauty Gadgets',
                    'Household',
                ]
            ],
            [
                'name' => 'Acer SF114-32-C10N Swift 1 4GB RAM Laptop',
                'unit_price' => 700,
                'stock' => 5,
                'meta' => [
                    'Processor' => 'Intel Pentium Sliver N5000',
                    'Memory' => '4096MB',
                    'Weight' => '1.4kg',
                ],
                'categories' => [
                    'Smart Tech',
                    'Laptops',
                    'Digital',
                    'Computing',
                ]
            ],
            [
                'name' => 'Xbox One X Gaming Console',
                'unit_price' => 700,
                'stock' => 5,
                'meta' => [
                    'Dimensions' => '30cm X 24cm X 6cm',
                    'Weight' => '3.81kg',
                    'Disk drive' => '4K UHD Blu-ray Drive',
                    'Power supply' => '245W (internal)',
                ],
                'categories' => [
                    'Smart Tech',
                    'Computing',
                    'Digital',
                ]
            ],
            [
                'name' => 'NESPRESSO CREATISTA PLUS J520-SG-ME-NE',
                'unit_price' => 750,
                'stock' => 5,
                'meta' => [
                    'Model' => 'Creatista Plus',
                    'Product Type' => 'Capsule Coffee Machines',
                    'Product Height/Width/Depth' => '30.8cm/17.1cm/39.3cm',
                    'Weight' => '0.450kg',
                    'Pump Pressure (bar)' => '19',
                    'Water Capacity (litres)' => '1.5',
                ],
                'categories' => [
                    'Smart Tech',
                    'Household',
                ]
            ],
            [
                'name' => 'Apple Watch Nike+ Series 4 MTXF2 (GPS + Cellular) 40mm - Silver Aluminium Case with Summit White Nike Sport Loop',
                'unit_price' => 750,
                'stock' => 5,
                'meta' => [
                    'Includes' => 'Watch Series 4GPS + Cellular, Phone calling function, 16GB Internal Memory, Siri Zvoice Control, Acitivity Notifications and Runs Apps',
                    'Battery Life' => '18 Hours',
                ],
                'categories' => [
                    'Smart Tech',
                    'Sports Accessories',
                ]
            ],
            [
                'name' => 'Polar Vantage V Watch',
                'unit_price' => 830,
                'stock' => 5,
                'meta' => [
                    'Model' => 'Vantage V',
                    'Product Type' => 'Fitness Trackers s',
                    'Product Height/Width/Depth' => '4.6cm/4.6cm/1.3cm',
                    'Weight' => '0.066kg',
                    'Estimated Battery Life' => 'Up to 40 hours',
                ],
                'categories' => [
                    'Smart Tech',
                    'Sports Accessories',
                ]
            ],
        ];

        $this->execute($items);
    }

    public function execute($data)
    {
        for ($i = 0; $i < count($data); $i++) {
            $metadata = [];

            foreach ($data[$i]['meta'] as $key => $val) {
                $metadata[] = [
                    'key' => $key,
                    'val' => $val,
                ];
            }

            $data[$i]['meta'] = $metadata;

            $data[$i]['meta'] = $data[$i]['meta'];

            $inventoryData = collect($data[$i])->except('categories')->toArray();

            $inventory = Inventory::create($inventoryData);

            $key = $i+1;

            InventoryPhoto::create([
                'inventory_id' => $inventory->id,
                'is_primary'   => 1,
                'file'         => "default-reward-$key.jpg",
            ]);

            foreach ($data[$i]['categories'] as $c) {
                $category = Category::firstOrCreate(['name' => $c]);
                $inventory->categories()->attach($category->id);
            }
        }
    }
}
