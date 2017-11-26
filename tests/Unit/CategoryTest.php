<?php

namespace Tests\Unit;

use App\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;
    protected $cat;

    protected function setUp()
    {
        parent::setUp();

        $this->cat = factory(Category::class)->create();
    }

    /** @test */
    public function a_category_may_belong_to_a_parent_category()
    {
        $child = factory(Category::class)->create(['f_id_categorie' => $this->cat->id_categorie]);

        $this->assertInstanceOf(Category::class, $child->category);
        $this->assertEquals(2, Category::count());
    }

    /** @test */
    public function a_category_may_have_many_subcategories()
    {
        $child = factory(Category::class)->create(['f_id_categorie' => $this->cat->id_categorie]);

        $this->assertInstanceOf(Collection::class, $this->cat->children);
        $this->assertCount(1, $this->cat->children);
        $this->assertTrue($this->cat->children->contains($child));
    }

    /** @test */
    public function a_category_has_products()
    {
        $this->assertInstanceOf(Collection::class, $this->cat->produits);
    }

    /** @test */
    public function a_category_can_add_sub_category()
    {
        $this->cat->addChildCategory([
            'nom_categorie' => 'Foobar'
        ]);

        $this->assertCount(1, $this->cat->children);
    }

    /** @test */
    public function categories_can_be_fetch_by_api_request()
    {
        $this->signIn();

        factory(Category::class, 20)->create(['f_id_categorie' => $this->cat->id_categorie]);

        $response = $this->getJson('/api/categories')->json();

        $this->assertCount(1, $response['data']);
        $this->assertCount(20, $response['data'][0]['children']);
    }
}
