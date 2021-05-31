<?php

use App\Models\Edm;
use App\Models\EdmFile;
use Illuminate\Database\Seeder;

class EdmFinalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'SEND W/ TOKENS',
            'RECEIVE W/ TOKENS',
        ];

        $edms = [];

        foreach ($data as $edmName) {
            $edms[] = Edm::create([
                'name' => $edmName
            ]);
        }

        foreach ($edms as $edm) {
            EdmFile::create([
                'edm_id' => $edm->id,
                'file'   => 'default',
                'is_active' => 1,
            ]);
        }
    }
}
