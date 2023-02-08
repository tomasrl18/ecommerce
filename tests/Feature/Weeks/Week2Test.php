<?php

namespace Tests\Feature\Weeks;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Week2Test extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function login_and_register_links_are_shown_if_you_are_not_logged_in()
    {
        Category::factory()->create();
        Subcategory::factory()->create();

        $this->get('/')
            ->assertSee('Iniciar sesión')
            ->assertSee('Registrarse');
    }

    /** @test */
    function profile_and_logout_links_are_shown_if_you_are_logged_in()
    {
        Category::factory()->create();
        Subcategory::factory()->create();

        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $this->post('/')->assertSee('Perfil');
    }
}
