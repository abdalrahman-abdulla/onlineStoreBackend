<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\category;
use Faker\Generator as Faker;

$factory->define(category::class, function (Faker $faker) {
    return [

            'name' => $faker->name,
            'slug' => $faker->slug,
            'description' => Str::random(11),
            'user_id' => factory(App\User::class),

    ];
});
