<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    $userIds = User::pluck('id');

    return [
        'user_id' => $faker->randomElement($userIds),
        'content' => $faker->paragraph(rand(1, 3)),
    ];
});
