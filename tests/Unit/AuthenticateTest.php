<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AuthenticateTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_authenticate()
    {
        $user = factory(User::class)->create();

        $this->post(route('login'), ['email' => $user->email, 'password' => 'secret'])
            ->assertRedirect(route('home'));
    }
}
