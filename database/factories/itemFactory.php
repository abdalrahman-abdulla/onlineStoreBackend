<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'slug' => $faker->slug,
        'description' => Str::random(11),
        'image' => Str::random(11),
        'price' => ($faker->randomDigit)*1000,
        'quantity'=> $faker->randomDigit,
        'subcategory_id' => factory(App\Subcategory::class),
    ];
});
