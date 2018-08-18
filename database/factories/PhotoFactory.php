<?php

use Faker\Generator as Faker;

$factory->define(App\Photo::class, function (Faker $faker) {
    return [
        "url" => "https://placeimg.com/640/480/" . $faker->word(),
    ];
});
