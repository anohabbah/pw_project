<?php

namespace Tests\Feature;

use App\Producteur;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateProducteurTest extends TestCase
{
    use DatabaseMigrations;

    protected $prod;

    protected function setUp()
    {
        parent::setUp();

        $this->prod = factory(Producteur::class)->create();
    }

    /** @test */
    public function authorized_user_can_create_producteur()
    {
        $this->signIn();
        $prod = factory(Producteur::class)->raw(['mot_de_passe' => 'secret']);
        $prod['mot_de_passe_confirmation'] = $prod['mot_de_passe'];

        $this->post(route('producteurs.store'), $prod);

        $this->assertDatabaseHas('producteurs', ['nom' => $prod['nom'], 'email' => $prod['email']]);
    }

    /** @test */
    public function unauthenticated_user_cannot_create_producteur()
    {
        $this->withExceptionHandling()
            ->post(route('producteurs.store', []))
            ->assertRedirect(route('login'));

        $this->get(route('producteurs.create'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function authorized_user_can_update_producteurs()
    {
        $this->signIn();
        $this->prod->nom = 'John Doe';
        $params = $this->prod->toArray();

        $this->patch(route('producteurs.update', $this->prod), $params);
        $this->assertDatabaseHas('producteurs', $params);
    }

    /** @test */
    public function unauthenticated_user_cannot_update_producteurs()
    {
        $this->withExceptionHandling()
            ->patch(route('producteurs.update', $this->prod), [])
            ->assertRedirect(route('login'));

        $this->get(route('producteurs.edit', $this->prod))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function un_producteur_est_caracterise_par_un_nom()
    {
        $this->publishProducteur(['nom' => null])
            ->assertSessionHasErrors('nom');
    }

    /** @test */
    public function un_producteur_est_caracterise_par_un_mail()
    {
        $this->publishProducteur(['email' => null])
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function un_producteur_est_caracterise_par_une_adresse()
    {
        $this->publishProducteur(['adresse' => null])
            ->assertSessionHasErrors('adresse');
    }

    /** @test */
    public function un_producteur_est_caracterise_par_un_numero_de_telephone()
    {
        $this->publishProducteur(['telephone' => null])
            ->assertSessionHasErrors('telephone');
    }

    /** @test */
    public function un_producteur_est_caracterise_par_une_description()
    {
        $this->publishProducteur(['bio' => null])
            ->assertSessionHasErrors('bio');
    }

    protected function publishProducteur(array $overrides = [])
    {
        $this->withExceptionHandling()
            ->signIn();

        $overrides['mot_de_passe'] = 'secret';
        $overrides['mot_de_passe_confirmation'] = 'secret';

        $producteur = factory(Producteur::class)
            ->raw($overrides);

        return $this->post(route('producteurs.store', $producteur));
    }

    /** @test */
    public function authorized_user_can_delete_prod()
    {
        $this->signIn();
        $this->delete(route('producteurs.destroy', $this->prod))
            ->assertRedirect(route('producteurs.index'));

        $this->assertDatabaseMissing('producteurs', ['id_producteur' => $this->prod->id_producteur]);
    }
}
