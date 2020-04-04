<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'bumbar@abv.bg')->first();

        // Set admin role manually! Trait EnumTrait reset role....

        if (!$user) {
            User::create([
                'name' => 'Vlad Dracula',
                'email' => 'dracula@vlad.com',
                'password' => Hash::make('password'),
            ]);

            User::create([
                'name' => 'Murmur',
                'email' => 'murmur@test.com',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
