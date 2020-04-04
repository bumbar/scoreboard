<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Departure;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Departure::class, function (Faker $faker) {

    $startDate = Carbon::now();
    $endDate   = Carbon::now()->addHours(24);

    $from = App\Models\City::pluck('id')->random();
    $to = App\Models\City::pluck('id')->random();

    $user_id = App\User::pluck('id')->random();

    $places = [30, 40, 50, 60 ,70, 80, 100];

    return [
        'from_id' => $from,
        'to_id' => function() use ($from, $to) {
            if ($from !== $to) {
               return $to;
            }
            return $to;
        },
        'departure_at' => Carbon::createFromTimestamp(rand($endDate->timestamp, $startDate->timestamp))
            ->format('Y-m-d H:i:s'),
        'user_id' => $user_id,
        'places' => $places[rand(0, count($places) - 1)],
        'price' => $faker->randomFloat(3, 0, 1000),
    ];
});
