<?php

use App\Models\Edm;
use App\Models\EdmFile;
use Illuminate\Database\Seeder;

class EdmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Token Sent',
            ],
            [
                'name' => 'Token Received',
            ],
            [
                'name' => 'Checkout',
            ],
        ];

        foreach ($data as $edm) {
            Edm::create($edm);
        }

        $this->seedFiles();
    }

    public function seedFiles()
    {
        $data = [
            [
                'edm_id' => 1,
                'file'   => 'default',
                'is_active' => 1,
            ],
            [
                'edm_id' => 2,
                'file'   => 'default',
                'is_active' => 1,
            ],
            [
                'edm_id' => 3,
                'file'   => 'default',
                'is_active' => 1,
            ],
        ];

        foreach ($data as $edmFile) {
            EdmFile::create($edmFile);
        }
    }
}
