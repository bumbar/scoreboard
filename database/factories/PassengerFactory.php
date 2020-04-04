<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Passenger;
use Faker\Generator as Faker;

$factory->define(Passenger::class, function (Faker $faker) {

    $departure_id = App\Models\Departure::pluck('id')->random();

    return [
        'name' => $faker->name,
        'rails' => rand(1,2),
        'human_status' => rand(1,4),
        'departure_id' => $departure_id,
    ];
});
