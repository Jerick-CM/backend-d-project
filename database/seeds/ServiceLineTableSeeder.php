<?php

use App\Models\User;
use App\Models\ServiceLine;
use Illuminate\Database\Seeder;

class ServiceLineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $serviceLines = [
            'Computing',
            'Management',
            'Consulting',
            'Training',
            'Finance',
            'Travel',
            'Media',
            'Distribution',
        ];

        foreach ($serviceLines as $sl) {
            $this->insert($sl);
        }

        $this->seedUsersServiceLine();
    }

    protected function insert($name)
    {
        ServiceLine::create([
            'name' => $name
        ]);
    }

    protected function seedUsersServiceLine()
    {
        $users = User::get();

        foreach ($users as $user) {
            $user->service_line_id = $this->getRandomServiceLine()->id;
            $user->save();
        }
    }

    protected function getRandomServiceLine()
    {
        return ServiceLine::inRandomOrder()->first();
    }
}
