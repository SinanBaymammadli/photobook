<?php

use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {
    return [
        "name" => $faker->word(),
        "img_url" => "storage/default-category.png",
    ];
});
