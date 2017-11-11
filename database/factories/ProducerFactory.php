<?php

use Faker\Generator as Faker;

$factory->define(App\Producer::class, function (Faker $faker) {
    return [
        'address' => $faker->address,
        'address_visibility' => $faker->randomElement([true, false]),
        'presentation' => $faker->paragraphs(5, true),
        'view' => $faker->paragraph
    ];
});
