<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Vote;
use Faker\Generator as Faker;

$factory->define(Vote::class, function (Faker $faker) {
    $userIds = User::pluck('id');

    return [
        'user_id' => $faker->randomElement($userIds),
        'vote' => $faker->randomElement([-1, 0, 1]),
    ];
});
