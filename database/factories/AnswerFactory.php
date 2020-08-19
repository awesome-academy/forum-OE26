<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Answer;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Answer::class, function (Faker $faker) {
    $userIds = User::pluck('id');

    return [
        'user_id' => $faker->randomElement($userIds),
    ];
});
