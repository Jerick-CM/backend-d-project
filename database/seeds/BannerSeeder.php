<?php

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banners = [
            [
                'title'  => 'Home Banner 1',
                'action' => '#',
                'file'   => 'home/banner-d.gif',
                'type' => 0,
            ],
            [
                'title'  => 'Redeem Banner 1',
                'action' => '#',
                'file'   => 'redeem/redeem-banner-1.png',
                'type' => 1,
            ],
            [
                'title'  => 'Redeem Banner 2',
                'action' => '#',
                'file'   => 'redeem/redeem-banner-2.png',
                'type' => 1,
            ],
            [
                'title'  => 'Redeem Banner 3',
                'action' => '#',
                'file'   => 'redeem/redeem-banner-3.png',
                'type' => 1,
            ],
            [
                'title'  => 'Redeem Banner 4',
                'action' => '#',
                'file'   => 'redeem/redeem-banner-4.png',
                'type' => 1,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }
    }
}
