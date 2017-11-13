<?php

use App\Category;
use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {
    $cat = $faker->words(3, true);
    return [
        'category_id' => null,
        'name' => ucwords($cat),
        'slug' => str_slug($cat)
    ];
});
