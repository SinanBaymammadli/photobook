<?php

use Faker\Generator as Faker;

$factory->define(App\OrderItem::class, function (Faker $faker) {
    return [
        "count" => $faker->numberBetween($min = 1, $max = 5),
        "product_type_id" => $faker->numberBetween($min = 1, $max = 50),
    ];
});
