<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //DB::table('users')->truncate();
        //DB::table('cities')->truncate();
        //DB::table('passengers')->truncate();
        //DB::table('departures')->truncate();

        //$this->call(UsersTableSeeder::class);
        //$this->call(CitiesTableSeeder::class);
        $this->call(DepartureTableSeeder::class);
        $this->call(PassengersTableSeeder::class);
    }
}
