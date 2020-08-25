<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName(),
        'email' => $faker->email(),
        'phone' => $faker->phoneNumber(),
        'country' => $faker->country(),
        'address' => $faker->address(),
        'city' => $faker->city(),
        'state' => $faker->state(),
        'postal_code' => $faker->postcode(),
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});
