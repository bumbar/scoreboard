<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Departure;
use App\Models\Passenger;
use Faker\Generator as Faker;

$factory->define(Passenger::class, function (Faker $faker) {

    // only first seed
    //$departure_id = Departure::pluck('id')->random();

    $max_departure_id = Departure::max('id');

    return [
        'name' => $faker->name,
        'rails' => rand(1,2),
        'human_status' => rand(1,4),
        //'departure_id' => $departure_id,
        'departure_id' => rand($max_departure_id, $max_departure_id - 50),
    ];
});
