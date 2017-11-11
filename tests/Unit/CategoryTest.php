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
        $child = factory(Category::class)->create(['category_id' => $this->cat->id]);

        $this->assertInstanceOf(Category::class, $child->category);
        $this->assertEquals(2, Category::count());
    }

    /** @test */
    public function a_category_may_have_many_subcategories()
    {
        $child = factory(Category::class)->create(['category_id' => $this->cat->id]);

        $this->assertInstanceOf(Collection::class, $this->cat->subCategories);
        $this->assertCount(1, $this->cat->subCategories);
        $this->assertTrue($this->cat->subCategories->contains($child));
    }

    /** @test */
    public function a_category_has_products()
    {
        $this->assertInstanceOf(Collection::class, $this->cat->products);
    }

    /** @test */
    public function a_category_can_add_sub_category()
    {
        $this->cat->addChildCategory([
            'name' => 'Foobar',
            'slug' => 'foobar'
        ]);

        $this->assertCount(1, $this->cat->subCategories);
    }
}
