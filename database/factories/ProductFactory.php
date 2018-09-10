<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        "name" => $faker->sentence($nbWords = 3, $variableNbWords = true),
        "price" => $faker->numberBetween($min = 10000, $max = 90000),
        "detail" => "30x40 cm"
    ];
});
