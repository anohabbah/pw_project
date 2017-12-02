<?php

use Faker\Generator as Faker;

$factory->define(App\Media::class, function (Faker $faker) {
    return [
        'url' => $faker->imageUrl(400, 400, 'people', true, 'profile')
    ];
});
