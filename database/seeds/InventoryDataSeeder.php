<?php

use App\Models\Inventory;
use Illuminate\Database\Seeder;

class InventoryDataSeeder extends Seeder
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
                'name' => '2017 Macbook Pro 13"',
                'description' => 'Features Apple MacBook Pro Core i5-3210M Dual-Core 2.5GHz 13.3" Notebook General Features: Silver color Mac OS X version 10.7.5 pre-installed Intel Core i5-3210M Dual-Core 2.5GHz processor',
                'meta' => [
                    'Processor' => '2.5GHz Dual Core Intel Core i5 Processor',
                    'Memory' => '8 GB DDR3 RAM',
                    'Storage' => '500 GB SSD',
                    'OS' => 'Mac OSX Sierra',
                ],
            ],
            [
                'name' => 'WD 500GB',
                'description' => 'The Samsung Portable SSD T5 elevates data transfer speeds to the next level and unleashes a new experience in external storage. With a compact and durable design and password protection, the T5 is truly easy to carry and stores data securely.',
                'meta' => [
                    'Storage' => '500GB',
                    'Speed' => '540MB/s',
                ]
            ],
            [
                'name' => 'Asus MX279H',
                'description' => 'With a stunning 27” IPS display, the MX279H monitor continues the elegance and visual prowess of the ASUS Designo line.',
                'meta' => [
                    'Resolution' => '1920x1080',
                    'Display Type' => 'LED',
                    'Frame' => '27" Full HD',
                ]
            ],
            [
                'name' => 'Logitech G430',
                'description' => 'Hear your enemies before they hear you. Experience your games like never before with 7.1 discreet channels of Dolby surround sound action in a comfort-built design.',
                'meta' => [
                    'Dimension' => '9.8 x 9 x 4.3 inches',
                    'Weight' => '10.6 ounces',
                ]
            ],
            [
                'name' => 'JBL GO',
                'description' => 'JBL GO Portable Wireless Bluetooth Speaker W/ A Built-In Strap-Hook (PINK)',
                'meta' => [
                    'Dimension' => '82.7 x 30.8 x 68.3 inches',
                    'Weight' => '4.6 ounces',
                ]
            ],
            [
                'name' => 'Samsung Galaxy S9',
                'description' => 'Introducing the revolutionary Galaxy S9+. The phone that reimagines the camera. And in doing so reimagines everything you can do, too.',
                'meta' => [
                    'Dimension' => '6.9 x 5.4 x 2.6 inches',
                    'Weight' => '14.4 ounces',
                    'Storage' => '64GB. Exapandable storage up to 400GB.',
                    'Camera' => 'Super Speed Dual Pixel Rear Dual: 12MP OIS (F1.5/F2.4) 12MP OIS (F2.4) Front: 8MP AF (F1.7)'
                ]
            ],
            [
                'name' => 'Razer Blackwidow Tournament Edition Chroma',
                'description' => 'Razer BlackWidow Tournament Edition Chroma RGB Mechanical Gaming Keyboard',
                'meta' => [
                    'Brand' => 'Razer',
                    'Dimension' => '14.4 x 6.3 x 1.6 inches',
                    'Weight' => '2.09 pounds',
                    'OS' => 'Windows',
                    'Color' => 'RGB Compact',
                ]
            ],
            [
                'name' => 'Logitech G502',
                'description' => 'G502 features an advanced optical sensor for maximum tracking accuracy, customizable RGB lighting, custom game profiles, from 200 up to 12,000 DPI, and repositionable weights.',
                'meta' => [
                    'Connection' => 'Wireless 802.11 a/b/g/n',
                    'Dimension' => '1.6 x 3 x 5.2 inches',
                    'Weight' => '4.3 ounces',
                    'OS' => 'Mac, PC',
                ]
            ],
            [
                'name' => 'Logitech G440',
                'description' => 'G440 features a low friction, hard polymer surface ideal for high DPI gaming, improving mouse control and precise cursor placement.',
                'meta' => [
                    'Dimension' => '13.4 x 0.1 x 11 inches',
                    'Weight' => '8 ounces',
                    'Color' => 'Black',
                ]
            ],
            [
                'name' => 'Kingston Digital 64 GB',
                'description' => "Store, transfer and share your favorite photos, videos, music and more with Kingston's Data Traveler SE9 G2 USB Flash drive.",
                'meta' => [
                    'Dimension' => '1.8 x 0.5 x 0.2 inches',
                    'Weight' => '1.6 ounces',
                    'Storage' => '64 GB',
                ]
            ],
            [
                'name' => 'Lock Keychain',
                'description' => 'Detailed with Tea Roses and our signature turn-lock in a mix of metallic hues, this functional design provides twice the key storage with two rings.',
                'meta' => [
                    'Package Dimensions' => '4.2 x 3.1 x 1 inches',
                    'Shipping Weight' => '4 ounces',
                ]
            ],
            [
                'name' => 'USB Stick Lamp',
                'description' => 'Limelights Stick Lamp with Charging Outlet and Fabric Shade, Grey',
                'meta' => [
                    'Dimension' => '8.3 x 8.3 x 19.3 inches',
                    'Weight' => '3.08 pounds'
                ]
            ],
            [
                'name' => 'Ausdom USB Web Cam',
                'description' => 'USB Webcam with Microphone, Computer Laptop Camera, Support Skype Facetime YouTube, Compatible for Mac OS Windows 10/8/7',
                'meta' => [
                    'Dimension' => '4.7 x 4.4 x 1.9 inches',
                    'Weight' => '5.1 ounces',
                    'Quality' => '1080p 12MP'
                ]
            ],
            [
                'name' => 'Logitech F710',
                'description' => 'Console-style control for your PC games - Experience the console-style gaming you crave on your PC with the Gamepad F710.',
                'meta' => [
                    'Dimension' => '6.8 x 2.9 x 8.1 inches',
                    'Weight' => '6.4 ounces',
                ]
            ],
            [
                'name' => 'Samsung Galaxy Tab E 9.6',
                'description' => 'Stay connected to everything you love with the Samsung Galaxy Tab E 9.6. Featuring a bright and spacious 9.6-inch screen, the Galaxy Tab E makes it easy to watch your favorite videos, snap photos, browse the Web, and more.',
                'meta' => [
                    'Resolution' => '1280 x 800 pixels',
                    'Display' => '9.6 inches',
                    'Processor' => '1.2 GHz Tablet Processor',
                    'Memory' => '1.5 GB DDR3',
                    'Storage' => '16 GB Flash Memory Solid State',
                    'Dimension' => '5.9 x 0.4 x 9.5 inches',
                    'Weight' => '1.21 pounds',
                ]
            ],
            [
                'name' => 'Swissgear ScanSmart Backpack',
                'description' => "For a bag that's ready for anything, the feature-rich Swissgear ScanSmart Backpack is ready when you are. A TSA-friendly lay flat laptop compartment eliminates the hassle of having to remove your computer when going through an airport security checkpoint.",
                'meta' => [
                    'Dimension' => '20.5 x 14.2 x 3.3 inches',
                    'Weight' => '2.9 pounds',
                    'Color' => 'Black',
                ]
            ],
            [
                'name' => 'Foldable Laptop Table',
                'description' => 'Write On Your Laptop, Watch Your Favorite Show While Enjoying Dinner, Or Even Play A Little Ladders & Snakes With Your Child – All From The Comfort Of Your Bed!',
                'meta' => [
                    'Dimension' => '23.2 x 16.1 x 10.4 inches',
                    'Weight' => '2.9 pounds',
                    'Color' => 'Black',
                ]
            ],
            [
                'name' => 'OneSpace Stanton Computer Desk',
                'description' => "The Stanton Computer desk with pull-out keyboard shelf features a compact and lightweight design that is a perfect addition to any small home office, kid's room, or any area that needs a work surface.",
                'meta' => [
                    'Dimension' => '30.5 x 22 x 4 inches',
                    'Weight' => '28.6 pounds',
                    'Color' => 'Black',
                ]
            ],
            [
                'name' => 'Devoko Ergonomic Gaming Chair',
                'description' => 'Devoko Ergonomic Gaming Chair Racing Style Adjustable Height High-back PC Computer Chair With Headrest and Lumbar Massage Support Executive Office Chair.',
                'meta' => [
                    'Dimension' => '20.5 x 19.8 x 50.5 inches',
                    'Weight' => '45.5 pounds',
                    'Color' => 'Blue',
                ]
            ],
            [
                'name' => 'Logitech Driving Force GT',
                'description' => 'The official wheel of Gran Turismo, featuring advanced force feedback technology. Make your racing experience even more realistic.',
                'meta' => [
                    'Dimension' => '12.8 x 14.1 x 11.4 inches',
                    'Weight' => '12.3 pounds',
                    'OS' => 'PS2, PS3, Windows XP/Vista/7',
                ]
            ]
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

            $data[$i]['meta'] = json_encode($data[$i]['meta']);
            Inventory::where('id', $i+1)->update($data[$i]);
        }
    }
}
