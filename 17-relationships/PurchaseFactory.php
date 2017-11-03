<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Purchase::class, function (Faker $faker) {
    return [
        'user_id' => \App\User::pluck('id')->random(),
        'date' => $faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
        'price' => $faker->randomFloat(2, 1, 100),
        'description' => ucfirst($faker->words(2, true))
    ];
});