<?php

use App\Models\Profanity;
use Illuminate\Database\Seeder;

class ProfanitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filePath = resource_path('json/profanities.json');

        $file = file_get_contents($filePath);

        $words = json_decode($file, true);

        foreach ($words as $key => $val) {
            Profanity::create([
                'word' => $val['Name']
            ]);
        }
    }
}
