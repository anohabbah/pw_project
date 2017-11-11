<?php

namespace Tests\Feature;

use App\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateCategoryTest extends TestCase
{
    use DatabaseMigrations;

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
            ->assertStatus(302);

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
            ->assertStatus(302);

        $cat = factory(Category::class)->create();
        $this->publishCategory(['parent_id' => $cat->id])
            ->assertStatus(302);

        $this->assertCount(1, $cat->refresh()->subCategories);
    }

    /**
     * @param array $overrides
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function publishCategory(array $overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $cat = factory(Category::class)->make($overrides);

        return $this->post(route('categories.store'), $cat->toArray());
    }
}
