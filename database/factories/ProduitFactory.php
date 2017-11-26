<?php

use App\Category;
use App\Producteur;
use Faker\Generator as Faker;

$factory->define(App\Produit::class, function (Faker $faker) {
    return [
        'id_categorie' => function () {
            return factory(Category::class)->create()->id_categorie;
        },
        'id_producteur' => function () {
            return factory(Producteur::class)->create()->id_producteur;
        },
        'intitule' => $faker->words(5, true),
        'description' => $faker->paragraphs(5, true),
        'prix' => $faker->numberBetween(0, 100) . ',' . $faker->numberBetween(0, 99)
    ];
});
