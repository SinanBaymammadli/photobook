<?php

use Faker\Generator as Faker;

$factory->define(App\OrderItemPhoto::class, function (Faker $faker) {
    return [
        "url" => "storage/default-avatar.png",
    ];
});
