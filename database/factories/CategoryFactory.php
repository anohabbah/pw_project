<?php

use App\Category;
use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {
    return [
        'f_id_categorie' => null,
        'nom_categorie' => ucwords($faker->words(3, true)),
    ];
});
