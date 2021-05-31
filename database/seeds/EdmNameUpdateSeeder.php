<?php

use App\Models\Edm;
use Illuminate\Database\Seeder;

class EdmNameUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Edm::where('id', 1)->update([
            'name' => 'SEND'
        ]);

        Edm::where('id', 2)->update([
            'name' => 'RECEIVE'
        ]);

        Edm::where('id', 3)->update([
            'name' => 'CHECK_OUT_REWARD'
        ]);
    }
}
