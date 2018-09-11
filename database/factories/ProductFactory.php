<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        "name" => $faker->sentence($nbWords = 3, $variableNbWords = true),
        "description" => $faker->text($maxNbChars = 200),
        "details" => $faker->text($maxNbChars = 600),
    ];
});
