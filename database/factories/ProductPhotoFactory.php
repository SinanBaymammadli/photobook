<?php

use Faker\Generator as Faker;

$factory->define(App\ProductPhoto::class, function (Faker $faker) {
    return [
        "url" => "storage/default-product.png",
    ];
});
