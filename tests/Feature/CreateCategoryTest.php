<?php

namespace Tests\Feature;

use App\Category;
use App\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateCategoryTest extends TestCase
{
    use DatabaseMigrations;

    protected $cat;

    protected function setUp()
    {
        parent::setUp();

        $this->cat = factory(Category::class)->create();
    }

    /** @test */
    public function guests_cannot_create_categories()
    {
        $this->withExceptionHandling()
            ->post(route('categories.store'), [])
            ->assertRedirect(route('login'));

        $this->get(route('categories.create'))
            ->assertRedirect('/login');
    }

    /** @test */
    public function authorized_user_can_create_a_category()
    {
        $this->signIn();

        $cat = factory(Category::class)->raw();

        $this->post(route('categories.store'), $cat)
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', ['name' => $cat['name'], 'slug' => $cat['slug']]);
    }

    /** @test */
    public function a_category_requires_a_name()
    {
        $this->publishCategory(['name' => null])
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_category_may_have_a_parent_category()
    {
        $this->publishCategory()
            ->assertRedirect(route('categories.index'));

        $this->publishCategory(['category_id' => $this->cat->id])
            ->assertRedirect(route('categories.index'));

        $this->assertCount(1, $this->cat->refresh()->subCategories);
    }

    /** @test */
    public function a_sub_category_requires_a_valid_parent()
    {
        $this->publishCategory(['category_id' => 2])
            ->assertSessionHasErrors('category_id');
    }

    /**
     * @param array $overrides
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function publishCategory(array $overrides = [])
    {
        $this->withExceptionHandling()
            ->signIn();

        $category = factory(Category::class)->make($overrides);

        return $this->post(route('categories.store'), $category->toArray());
    }

    /** @test */
    public function authorized_user_can_update_categories()
    {
        $this->signIn();

        $str = 'new name';
        $this->patch(route('categories.update', $this->cat), ['name' => $str]);

        $this->assertDatabaseHas('categories', ['id' => $this->cat->id, 'name' => $str]);
    }

    /** @test */
    public function unauthorized_users_cannot_update_categories()
    {
        $this->withExceptionHandling()
            ->patch(route('categories.update', $this->cat), [])
            ->assertRedirect('/login');

        $this->get(route('categories.edit', $this->cat))
            ->assertRedirect('/login');
    }

    /** @test */
    public function authorized_users_can_delete_categories()
    {
        $this->signIn();

        $child = factory(Category::class)->create(['category_id' => $this->cat->id]);
        $prod = factory(Product::class)->create(['category_id' => $this->cat->id]);

        $this->assertCount(1, $this->cat->subCategories);
        $this->assertCount(1, $this->cat->products);

        $this->delete(route('categories.destroy', $this->cat));

        $this->assertDatabaseMissing('categories', ['id' => $this->cat->id]);
        $this->assertDatabaseMissing('categories', ['id' => $child->id]);
        $this->assertDatabaseMissing('products', ['id' => $prod->id]);
    }
}
