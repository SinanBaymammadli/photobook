<?php

use Faker\Generator as Faker;

$factory->define(App\ProductType::class, function (Faker $faker) {
    return [
        "name" => $faker->safeColorName() . "-" . $faker->safeColorName(),
        "price" => $faker->numberBetween($min = 10000, $max = 90000),
        "detail" => $faker->randomElement(['Passepartout 30X30 Billede str. 20x20cm', 'Passepartout 30X30 Billede str. 20x20cm']),
        "img_url" => "default-product-type.png",
        "photo_count" => $faker->numberBetween($min = 1, $max = 5),
    ];
});
