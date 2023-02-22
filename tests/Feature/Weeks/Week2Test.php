<?php

namespace Tests\Feature\Weeks;

use App\Http\Livewire\{CategoryFilter, CategoryProducts};
use App\Models\{Brand, Category, Image, Product, Subcategory, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Livewire\Livewire;
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

        $products = Product::factory(5)->create([
            'name' => Str::random(10),
            'subcategory_id' => $subcategory->id,
            'brand_id' => $brand->id,
        ])->each(function(Product $product){
            Image::factory()->create([
                'imageable_id' => $product->id,
                'imageable_type' => Product::class
            ]);
        });

        Livewire::test(CategoryProducts::class, ['category' => $category])
            ->set('products', $products)
            ->assertSee($products[0]->name)
            ->assertSee($products[1]->name)
            ->assertSee($products[2]->name)
            ->assertSee($products[3]->name)
            ->assertSee($products[4]->name);
    }

    /** @test */
    function in_the_main_view_you_can_see_five_published_products_of_a_category()
    {
        $category = Category::factory()->create();
        $subcategory = Subcategory::factory()->create();
        $brand = Brand::factory()->create();
        $brand->categories()->attach($category->id);

        $products = Product::factory(5)->create([
            'name' => Str::random(10),
            'subcategory_id' => $subcategory->id,
            'brand_id' => $brand->id,
            'status' => 2,
        ])->each(function(Product $product){
            Image::factory()->create([
                'imageable_id' => $product->id,
                'imageable_type' => Product::class
            ]);
        });

        for ($i = 0; $i < 6; $i++) {
            $product = Product::factory()->create([
                'name' => Str::random(10),
                'subcategory_id' => $subcategory->id,
                'brand_id' => $brand->id,
                'status' => 1,
            ]);

            Image::factory()->create([
                'imageable_id' => $product->id,
                'imageable_type' => Product::class
            ]);

            $products[] = $product;
        }

        Livewire::test(CategoryProducts::class, ['category' => $category])
            ->call('loadProducts')
            ->assertSee($products[0]->name)
            ->assertSee($products[1]->name)
            ->assertSee($products[2]->name)
            ->assertSee($products[3]->name)
            ->assertSee($products[4]->name)
            ->assertDontSee($products[5]->name)
            ->assertDontSee($products[6]->name)
            ->assertDontSee($products[7]->name)
            ->assertDontSee($products[8]->name)
            ->assertDontSee($products[9]->name);
    }

    /** @test */
    function can_access_to_the_detail_view_of_a_category()
    {
        $category = Category::factory()->create();

        $subc1 = Subcategory::factory()->create([
            'name' => 'Subcategoria 1',
        ]);

        $subc2 = Subcategory::factory()->create([
            'name' => 'Subcategoria 2',
        ]);

        $b1 = Brand::factory()->create([
            'name' => 'Marca 1',
        ]);

        $b2 = Brand::factory()->create([
            'name' => 'Marca 2',
        ]);

        $b1->categories()->attach($category->id);
        $b2->categories()->attach($category->id);

        $p1 = Product::factory()->create([
            'name' => Str::random(10),
            'subcategory_id' => $subc1->id,
            'brand_id' => $b1->id,
        ]);

        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);

        $p2 = Product::factory()->create([
            'name' => Str::random(10),
            'subcategory_id' => $subc2->id,
            'brand_id' => $b2->id,
        ]);

        Image::factory()->create([
            'imageable_id' => $p2->id,
            'imageable_type' => Product::class
        ]);

        Livewire::test(CategoryFilter::class, ['category' => $category])
            ->assertSee('Subcategoria 1')
            ->assertSee('Subcategoria 2')
            ->assertSee('Marca 1')
            ->assertSee('Marca 2')
            ->assertSee($p1->name)
            ->assertSee($p2->name);
    }

    /** @test */
    function the_products_are_filtered_by_brand_or_subcategory()
    {
        $category = Category::factory()->create();

        $subc1 = Subcategory::factory()->create([
            'name' => 'Subcategoria 1',
        ]);

        $subc2 = Subcategory::factory()->create([
            'name' => 'Subcategoria 2',
        ]);

        $b1 = Brand::factory()->create([
            'name' => 'Marca 1',
        ]);

        $b2 = Brand::factory()->create([
            'name' => 'Marca 2',
        ]);

        $b1->categories()->attach($category->id);
        $b2->categories()->attach($category->id);

        $p1 = Product::factory()->create([
            'name' => Str::random(10),
            'subcategory_id' => $subc1->id,
            'brand_id' => $b1->id,
        ]);

        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);

        $p2 = Product::factory()->create([
            'name' => Str::random(10),
            'subcategory_id' => $subc1->id,
            'brand_id' => $b1->id,
        ]);

        Image::factory()->create([
            'imageable_id' => $p2->id,
            'imageable_type' => Product::class
        ]);

        $p3 = Product::factory()->create([
            'name' => Str::random(10),
            'subcategory_id' => $subc2->id,
            'brand_id' => $b2->id,
        ]);

        Image::factory()->create([
            'imageable_id' => $p3->id,
            'imageable_type' => Product::class
        ]);

        $p4 = Product::factory()->create([
            'name' => Str::random(10),
            'subcategory_id' => $subc2->id,
            'brand_id' => $b2->id,
        ]);

        Image::factory()->create([
            'imageable_id' => $p4->id,
            'imageable_type' => Product::class
        ]);

        Livewire::test(CategoryFilter::class, ['category' => $category])
            ->set('subcategoria', $subc1->slug)
            ->assertSee($p1->name)
            ->assertSee($p2->name)
            ->assertDontSee($p3->name)
            ->assertDontSee($p4->name);
    }
}
