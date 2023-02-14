<?php

namespace Tests\Feature\Weeks;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
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

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $this->post('/')->assertSee('Perfil');
    }

    /** @test */
    function in_the_main_view_you_can_see_five_products_of_a_category()
    {
        $category = Category::factory()->create();
        $subcategory = Subcategory::factory()->create();
        $brand = Brand::factory()->create();
        $brand->categories()->attach($category->id);

        $p1 = Product::factory()->create([
            'name' => 'Producto 1',
            'subcategory_id' => $subcategory->id,
            'brand_id' => $category->brands->random(),
        ]);

//        $p2 = Product::factory()->create([
//            'name' => 'Producto 2',
//            'subcategory_id' => $subcategory->id,
//        ]);
//
//        $p3 = Product::factory()->create([
//            'name' => 'Producto 3',
//            'subcategory_id' => $subcategory->id,
//        ]);
//
//        $p4 = Product::factory()->create([
//            'name' => 'Producto 4',
//            'subcategory_id' => $subcategory->id,
//        ]);
//
//        $p5 = Product::factory()->create([
//            'name' => 'Producto 5',
//            'subcategory_id' => $subcategory->id,
//        ]);

        $this->assertDatabaseHas('products', [
            'name' => $p1->name,
            'subcategory_id' => $p1->subcategory_id,
        ]);

        /*$this->get('/')
            ->assertSee($p1->name);*/
    }
}
