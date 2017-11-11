<?php

use App\Category;
use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {
    $cat = $faker->unique()->word;
    return [
        'category_id' => null,
        'name' => $cat,
        'slug' => str_slug($cat)
    ];
});
