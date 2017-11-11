<?php

use App\Category;
use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'category_id' => function () {
            return factory(Category::class)->create()->id;
        },
        'entitled' => $faker->words(3, true),
        'description' => $faker->paragraphs(5, true),
        'price' => $faker->numberBetween(0, 100) . ',' . $faker->numberBetween(0, 99)
    ];
});
