<?php

namespace Tests\Feature;

use App\Category;
use App\Produit;
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
        unset($cat['f_id_categorie']);

        $this->post(route('categories.store'), $cat)
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', $cat);


        $cat = factory(Category::class)->raw(['f_id_categorie' => $this->cat->id_categorie]);

        $this->post(route('categories.store'), $cat)
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', $cat);
    }

    /** @test */
    public function a_category_requires_a_name()
    {
        $this->publishCategory(['nom_categorie' => null])
            ->assertSessionHasErrors('nom_categorie');
    }

    /** @test */
    public function a_category_may_have_a_parent_category()
    {
        $this->publishCategory()
            ->assertRedirect(route('categories.index'));

        $this->publishCategory(['f_id_categorie' => $this->cat->id_categorie])
            ->assertRedirect(route('categories.index'));

        $this->assertCount(1, $this->cat->refresh()->children);
    }

    /** @test */
    public function a_sub_category_requires_a_valid_parent()
    {
        $this->publishCategory(['f_id_categorie' => 2])
            ->assertSessionHasErrors('f_id_categorie');
    }

    /**
     * @param array $overrides
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function publishCategory(array $overrides = [])
    {
        $this->withExceptionHandling()
            ->signIn();

        $category = factory(Category::class)->raw($overrides);
        if (!array_has($overrides, 'f_id_categorie')) {
            unset($category['f_id_categorie']);
        }

        return $this->post(route('categories.store'), $category);
    }

    /** @test */
    public function authorized_user_can_update_categories()
    {
        $this->signIn();

        $str = 'new name';
        $this->patch(route('categories.update', $this->cat), ['nom_categorie' => $str]);

        $this->assertDatabaseHas('categories',
            ['id_categorie' => $this->cat->id_categorie, 'nom_categorie' => $str]);
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

        $child = factory(Category::class)->create(['f_id_categorie' => $this->cat->id_categorie]);
        $prod = factory(Produit::class)->create(['id_categorie' => $this->cat->id_categorie]);

        $this->assertCount(1, $this->cat->children);
        $this->assertCount(1, $this->cat->produits);

        $this->delete(route('categories.destroy', $this->cat));

        $this->assertDatabaseMissing('categories', ['id_categorie' => $this->cat->id_categorie]);
        $this->assertDatabaseMissing('categories', ['id_categorie' => $child->id_categorie]);
        $this->assertDatabaseMissing('produits', ['id_produit' => $prod->id_produit]);
    }
}
