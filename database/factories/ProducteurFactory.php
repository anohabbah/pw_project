<?php

use Faker\Generator as Faker;

$factory->define(App\Producteur::class, function (Faker $faker) {
    return [
        'adresse' => $faker->address,
        'adresse_visible' => $faker->randomElement([true, false]),
        'nom' => $faker->name,
        'telephone' => $faker->phoneNumber,
        'email' => $faker->freeEmail,
        'mot_de_passe' => bcrypt('secret'),
        'state' => $faker->randomElement([true, false]),
        'long' => $faker->longitude,
        'lat' => $faker->latitude,
        'bio' => $faker->paragraphs(5, true),
    ];
});
