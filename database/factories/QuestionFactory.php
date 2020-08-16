<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    $userIds = User::pluck('id');

    return [
        'user_id' => $faker->randomElement($userIds),
        'title' => $faker->sentence(rand(5, 20)),
        'views_number' => rand(0, 1000),
        'best_answer' => null,
        'activities_count' => rand(0, 1000),
        'active_at' => $faker->dateTime(),
    ];
});
