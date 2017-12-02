<?php

use Illuminate\Database\Seeder;

class ProducteursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Producteur::class, 20)->create()
            ->each(function ($prod) {
                factory(\App\Media::class)->create(['id_producteur' => $prod->id_producteur]);
            });
    }
}
