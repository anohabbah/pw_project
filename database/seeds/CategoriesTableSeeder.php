<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Category::class, 10)
            ->create()
            ->each(function ($cat) {
                factory(Category::class, 5)->create(['f_id_categorie' => $cat->id_categorie]);
            });
    }
}
