<?php

use App\Category;
use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'category_id' => function () {
            return factory(Category::class)->create()->id;
        },
        'entitled' => $faker->words,
        'description' => $faker->paragraphs,
        'price' => $faker->numberBetween(0, 100) . ',' . $faker->numberBetween(0, 99)
    ];
});
