<?php

use App\Models\ContactEmail;
use Illuminate\Database\Seeder;

class ContactEmailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contact_emails')->insert([
            [
                'type' => 1,
                'name' => 'Technical Issue',
                'email' => 'clarence@influenz.sg',
            ],
            [
                'type' => 2,
                'name' => 'Redemption',
                'email' => 'mark@influenz.sg',
            ],
            [
                'type' => 3,
                'name' => 'Access',
                'email' => 'clarence@influenz.sg',
            ],
            [
                'type' => 4,
                'name' => 'Tokens/Badges',
                'email' => 'mark@influenz.sg',
            ],
            [
                'type' => 5,
                'name' => 'Message',
                'email' => 'clarence@influenz.sg',
            ],
        ]);
    }
}
