<?php

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgesTableSeeder extends Seeder
{
    /**
     * List of badges
     *
     * @var array
     */
    protected $badges = [
        'Brand Ambassador',
        'Coaching Superstar',
        'Quality Champion',
        'High Performer',
        'Collaborator',
        'Innovator',
        'Client Leader',
        'WorldClass Citizen',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->badges as $badge) {
            Badge::create([
                'name' => $badge,
            ]);
        }
    }
}
