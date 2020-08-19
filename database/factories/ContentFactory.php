<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Content;
use Faker\Generator as Faker;

$factory->define(Content::class, function (Faker $faker) {
    return [
        'content' => $faker->paragraph(rand(1, 10)),
        'version' => 0,
    ];
});
