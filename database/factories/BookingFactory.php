<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Booking;
use App\User;
use App\Room;
use Faker\Generator as Faker;

$factory->define(Booking::class, function (Faker $faker) {
    $usersId = collect(User::all()->pluck('id'));
    $roomsId = collect(Room::all()->pluck('id'));
    return [
        'user_id' => $usersId->random(),
        'room_id' => $roomsId->random(),
        'check_in' => $faker->dateTimeBetween($startDate = 'now', $endDate = '15 days', $timezone = null),
        'check_out' => $faker->dateTimeBetween($startDate = '15 days', $endDate = '30 days', $timezone = null),
        'guests' => $faker->randomDigitNot(0),
        'created_at' => $faker->dateTimeBetween($startDate = '-7 days',$endDate = '10 days', $timezone = null),
        'updated_at' => $faker->dateTime($startDate = 'now'),
    ];
});
