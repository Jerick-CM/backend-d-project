<?php

use App\Models\ContactEmail;
use Illuminate\Database\Seeder;

class ContactEmailProdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contactEmails = [
            [
                'type'  => 1,
                'name'  => 'Technical Issue',
                'email' => config('contact.technical'),
            ],
            [
                'type'  => 2,
                'name'  => 'Redemption',
                'email' => config('contact.redemption'),
            ],
            [
                'type'  => 3,
                'name'  => 'Access',
                'email' => config('contact.access'),
            ],
            [
                'type'  => 4,
                'name'  => 'Tokens/Badges',
                'email' => config('contact.tokens'),
            ],
            [
                'type'  => 5,
                'name'  => 'Message',
                'email' => config('contact.messages'),
            ],
            [
                'type'  => 6,
                'name'  => 'Others',
                'email' => config('contact.others'),
            ]
        ];

        foreach ($contactEmails as $contactEmail) {
            ContactEmail::updateOrCreate([
                'type' => $contactEmail['type']
            ], [
                'name'  => $contactEmail['name'],
                'email' => $contactEmail['email']
            ]);
        }
    }
}
