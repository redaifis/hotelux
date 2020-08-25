<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Room;
use Faker\Generator as Faker;

$factory->define(Room::class, function (Faker $faker) {
    return [
        'title' => $faker->title(),
        'description' => $faker->paragraph(),
        'price' => $faker->randomNumber($max = 1000),
        'capacity' => $faker->randomDigitNot(0),
        'published' => $faker->randomElement([0,1]),
        'created_at' => $faker->dateTime($min = '-30 days', $max = 'today'),
    ];
});
