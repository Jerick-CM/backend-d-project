<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class SetAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('azure_id', config('user.admin_azure_id'))->first();

        if (! $user) {
            return false;
        }

        $user->is_admin = true;
        $user->save();
    }
}
