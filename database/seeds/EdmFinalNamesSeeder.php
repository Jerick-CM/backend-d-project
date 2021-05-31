<?php

use App\Models\Edm;
use Illuminate\Database\Seeder;

class EdmFinalNamesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'MESSAGE SEND',
            'MESSAGE RECEIVED',
            'REDEMPTION',
            'WELCOME',
            'MESSAGE SEND TOKEN',
            'MESSAGE RECEIVED TOKEN',
            'MONTHLY SUMMARY',
        ];

        $edms = Edm::get();

        for ($i = 0; $i < count($edms); $i++) {
            $edms[$i]->name = $names[$i];
            $edms[$i]->save();
        }
    }
}
