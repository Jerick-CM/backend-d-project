<?php

use App\Models\User;
use App\Repositories\MessageRepository;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    protected $users;

    protected $faker;

    public function __construct(Faker $faker)
    {
        $this->users = User::get();

        $this->faker = $faker;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $messageRepo = new MessageRepository();

        for ($i = 0; $i < count($this->users); $i++) {
            foreach ($this->users as $user) {
                if ($user->id === $this->users[$i]->id) {
                    continue;
                }

                $credits = 10;
                $badgeId = $this->randomBadge();

                $messageRepo->sendMessage(
                    $this->users[$i]->id,
                    $user->id,
                    $badgeId,
                    $credits,
                    $this->faker->text(250)
                );
            }
        }
    }

    public function randomBadge()
    {
        return rand(1, 7);
    }
}
