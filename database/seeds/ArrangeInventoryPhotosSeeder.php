<?php

use App\Models\InventoryPhoto;
use Illuminate\Database\Seeder;

class ArrangeInventoryPhotosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $photos = InventoryPhoto::get();

        $groupedPhotos = $photos->groupBy('inventory_id');

        foreach ($groupedPhotos as $gp) {
            foreach ($gp as $key => $p) {
                $photo = InventoryPhoto::find($p->id);
                $photo->order = $key + 1;
                $photo->save();
            }
        }
    }
}
