<?php

$factory->define(\App\Models\RealEstate::class, function (Faker\Generator $faker) {
    return [
        'address_line_1' => $faker->address,
        'address_line_2' => $faker->address,
        'city' => $faker->city,
        'postcode' => $faker->postcode
    ];
});
