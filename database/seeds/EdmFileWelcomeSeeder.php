<?php

use App\Models\Edm;
use App\Models\EdmFile;
use Illuminate\Database\Seeder;

class EdmFileWelcomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Edm::create([
            'name' => 'WELCOME',
        ]);

        EdmFile::create([
            'edm_id' => 4,
            'file'   => 'default',
            'is_active' => 1,
        ]);
    }
}
