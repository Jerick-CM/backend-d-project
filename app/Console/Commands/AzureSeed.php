<?php

namespace App\Console\Commands;

use App\Helpers\GraphHelper;
use Faker\Generator as Faker;
use Illuminate\Console\Command;

class AzureSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'azure:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed new users to Azure AD';

    /**
     * Instance of GraphHelper
     *
     * @var GraphHelper
     */
    protected $graphHelper;

    /**
     * Instance of Faker
     *
     * @var Faker
     */
    protected $faker;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(GraphHelper $graphHelper, Faker $faker)
    {
        parent::__construct();

        $this->graphHelper = $graphHelper;
        $this->faker = $faker;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $token = $this->graphHelper->authenticateApp();

        $users = [];

        $tenant = config('services.graph.tenant');

        for ($i = 0; $i < 20; $i++) {
            $fname = $this->faker->unique()->firstName;
            $lname = $this->faker->lastName;
            $fullName = "$fname $lname";

            $email = "$fname@$tenant";

            $users[] = [
                'accountEnabled' => true,
                'displayName' => $fullName,
                'mailNickname' => $fname,
                'passwordProfile' => [
                    'forceChangePasswordNextSignIn' => true,
                    'password' => $this->faker->unique()->password,
                ],
                'userPrincipalName' => $email,
            ];
        }

        $successCount = 0;
        $failCount = 0;

        foreach ($users as $user) {
            $response = $this->graphHelper
                ->setToken($token)
                ->run('POST', 'users', $user);

            if ($response instanceof \Exception) {
                \Log::info($response);
                $failCount++;
                continue;
            }

            $successCount++;
        }

        echo "$successCount succeeded, $failCount failed\n";
    }
}
