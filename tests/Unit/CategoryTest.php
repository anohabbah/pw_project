<?php

namespace Tests\Unit;

use App\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_category_may_belong_to_a_parent_category()
    {
        $parent = factory(Category::class)->create();
        $child = factory(Category::class)->create(['parent_id' => $parent->id]);

        $this->assertInstanceOf(Category::class, $child->parent);
        $this->assertEquals(2, Category::count());
    }

    /** @test */
    public function a_category_may_have_many_subcategories()
    {
        $parent = factory(Category::class)->create();
        $child = factory(Category::class)->create(['parent_id' => $parent->id]);

        $this->assertInstanceOf(Collection::class, $parent->subCategories);
        $this->assertCount(1, $parent->subCategories);
        $this->assertTrue($parent->subCategories->contains($child));
    }
}
