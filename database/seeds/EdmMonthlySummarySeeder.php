<?php

use App\Models\Edm;
use App\Models\EdmFile;
use Illuminate\Database\Seeder;

class EdmMonthlySummarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $edm = Edm::create([
            'name' => 'MONTHLY SUMMARY',
        ]);

        $edmFile = EdmFile::create([
            'edm_id' => $edm->id,
            'file'   => 'default',
            'is_active' => 1,
        ]);
    }
}
