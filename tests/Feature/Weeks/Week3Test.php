<?php

namespace Tests\Feature\Weeks;

use App\Http\Livewire\{AddCartItem, AddCartItemColor, AddCartItemSize, CreateOrder, DropdownCart, Search, ShoppingCart, UpdateCartItem};
use App\Models\{Brand, Category, City, Color, Department, District, Image, Product, Size, Subcategory, User};
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use Tests\TestCase;

class Week3Test extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_product_without_color_is_added_to_the_shopping_cart()
    {
        $p1 = $this->createProduct();
        $p2 = $this->createProduct();

        Livewire::test(AddCartItem::class, ['product' => $p1])
            ->call('addItem', $p1)
            ->assertStatus(200);

        Livewire::test(ShoppingCart::class)
            ->assertSee($p1->name)
            ->assertDontSee($p2->name);
    }

    /** @test */
    function a_product_with_color_but_without_size_is_added_to_the_shopping_cart()
    {
        $p1 = $this->createProduct(true);
        $p2 = $this->createProduct();

        Livewire::test(AddCartItemColor::class, ['product' => $p1])
            ->call('addItem', $p1)
            ->assertStatus(200);

        Livewire::test(ShoppingCart::class)
            ->assertSee($p1->name)
            ->assertDontSee($p2->name);
    }

    /** @test */
    function a_product_with_color_and_size_is_added_to_the_shopping_cart()
    {
        $p1 = $this->createProduct(true, true);
        $p2 = $this->createProduct(true, true);

        $size = $p1->sizes->first();
        $color = $p1->sizes->first()->colors->first();

        Livewire::test(AddCartItemSize::class, ['product' => $p1])
            ->set('options', [
                'size' => $size->name,
                'color' => $color->name,
            ])
            ->call('addItem', $p1)
            ->assertStatus(200);

        Livewire::test(ShoppingCart::class)
            ->assertSee($p1->name)
            ->assertDontSee($p2->name);
    }

    /** @test */
    function it_shows_the_items_when_click_in_the_icon_cart()
    {
        $p1 = $this->createProduct();
        $p2 = $this->createProduct();

        Livewire::test(AddCartItem::class, ['product' => $p1])
            ->call('addItem', $p1)
            ->assertStatus(200);

        Livewire::test(DropdownCart::class)
            ->assertSee($p1->name)
            ->assertDontSee($p2->name);
    }

    /** @test */
    function the_number_of_the_red_circle_of_the_shopping_cart_increments_when_an_item_is_added()
    {
        $p1 = $this->createProduct();
        $p2 = $this->createProduct();

        Livewire::test(AddCartItem::class, ['product' => $p1])
            ->set('qty', 13)
            ->call('addItem', $p1)
            ->assertStatus(200);

        Livewire::test(DropdownCart::class)
            ->assertSee(13)
            ->assertSee($p1->name)
            ->assertDontSee($p2->name);

        Livewire::test(AddCartItem::class, ['product' => $p2])
            ->call('addItem', $p2)
            ->assertStatus(200);

        Livewire::test(DropdownCart::class)
            ->assertSee(14)
            ->assertSee($p1->name)
            ->assertSee($p2->name);
    }

    /** @test */
//    function it_is_not_possible_to_add_more_products_than_the_total_stock_to_the_shopping_cart()
//    {
//        $quantity = 2;
//        $p1 = $this->createProduct(false, false, $quantity);
//
//        for ($i = 0; $i < 3; $i++) {
//            Livewire::test(AddCartItem::class, ['product' => $p1])
//                ->call('addItem', $p1);
//        }
//
//        Livewire::test(DropdownCart::class)
//            ->assertSee($p1->price)
//            ->assertSee($p1->name);
//    }

    /** @test */
    function we_can_see_the_stock_of_the_product()
    {
        $p1 = $this->createProduct();

        Livewire::test(AddCartItem::class, ['product' => $p1])
            ->assertViewHas('quantity', $p1->quantity);
    }

    /** @test */
    function the_search_can_filter_or_show_all_if_the_search_field_is_empty()
    {
        $p1 = $this->createProduct();

        $p2 = $this->createProduct();

        $p3 = $this->createProduct();

        Livewire::test(Search::class, ['product' => $p1])
            ->set('search', $p1->name)
            ->assertSee($p1->name)
            ->assertDontSee($p2->name)
            ->assertDontSee($p3->name);
    }

    /** @test */
    function we_can_see_all_the_items_that_have_the_cart_view()
    {
        $p1 = $this->createProduct();
        $p2 = $this->createProduct();
        $p3 = $this->createProduct();

        Livewire::test(AddCartItem::class, ['product' => $p1])
            ->call('addItem', $p1);

        Livewire::test(AddCartItem::class, ['product' => $p2])
            ->call('addItem', $p2);

        Livewire::test(ShoppingCart::class)
            ->assertSee($p1->name)
            ->assertSee($p2->name)
            ->assertDontSee($p3->name);
    }

    /** @test */
    function in_the_cart_view_we_can_change_the_quantity_of_any_of_the_products_and_the_total_column_also_changes()
    {
        $p1 = $this->createProduct();

        Livewire::test(AddCartItem::class, ['product' => $p1])
            ->call('addItem', $p1);

        $total = Cart::subtotal();

        Livewire::test(UpdateCartItem::class, ['rowId' => Cart::content()->first()->rowId])
            ->assertViewHas('qty', 1)
            ->call('increment')
            ->assertViewHas('qty', 2);

        $this->assertEquals($total * 2, Cart::subtotal());

        Livewire::test(UpdateCartItem::class, ['rowId' => Cart::content()->first()->rowId])
            ->assertViewHas('qty', 2)
            ->call('decrement')
            ->assertViewHas('qty', 1);

        $this->assertEquals($total, Cart::subtotal());
    }

    /** @test */
    function we_can_clean_the_cart_and_delete_a_product()
    {
        $p1 = $this->createProduct();
        $p2 = $this->createProduct();
        $p3 = $this->createProduct();

        Livewire::test(AddCartItem::class, ['product' => $p1])
            ->call('addItem', $p1);

        Livewire::test(AddCartItem::class, ['product' => $p2])
            ->call('addItem', $p2);

        Livewire::test(AddCartItem::class, ['product' => $p3])
            ->call('addItem', $p3);

        Livewire::test(ShoppingCart::class)
            ->call('delete', Cart::content()->first()->rowId)
            ->assertDontSee($p1->name);

        Livewire::test(ShoppingCart::class)
            ->call('destroy')
            ->assertDontSee($p2->name)
            ->assertDontSee($p3->name);
    }

    /** @test */
    function only_authenticated_users_can_see_the_create_order_view()
    {
        $p1 = $this->createProduct();

        Livewire::test(AddCartItem::class, ['product' => $p1])
            ->call('addItem', $p1);

        $user1 = User::factory()->create();

        $this->get(route('orders.create'))
            ->assertStatus(302);

        $this->post('/login', [
            'email' => $user1->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $this->get(route('orders.create'))
            ->assertStatus(200);
    }

    /** @test */
    function the_cart_is_saved_in_DB_when_logout_and_is_rescue_when_login()
    {
        $user1 = User::factory()->create();

        $this->post('/login', [
            'email' => $user1->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $p1 = $this->createProduct();

        Livewire::test(AddCartItem::class, ['product' => $p1])
            ->call('addItem', $p1);

        Auth::logout();

        $this->assertDatabaseCount('shoppingcart', 1);

        $this->actingAs($user1);

        Livewire::test(ShoppingCart::class)
            ->assertSee($p1->name);
    }

    /** @test */
    function we_can_create_an_order_and_then_the_cart_is_destroyed_and_then_redirect_to_the_new_route()
    {
        $p1 = $this->createProduct();

        $user1 = User::factory()->create();

        $this->post('/login', [
            'email' => $user1->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        Livewire::test(AddCartItem::class, ['product' => $p1])
            ->call('addItem');

        $this->assertEquals(Cart::count(), 1);
        $this->assertDatabaseCount('orders', 0);

        Livewire::test(CreateOrder::class)
            ->set('contact', 'Tomás')
            ->set('phone', '123456789')
            ->call('create_order')
            ->assertRedirect('orders/1/payment');

        $this->assertDatabaseCount('orders', 1);
        $this->assertEquals(Cart::count(), 0);
    }

    /** @test */
    function the_selected_selects_are_loaded_correctly_depending_of_the_options()
    {
        $p1 = $this->createProduct();

        $depa1 = Department::factory()->create([
            'name' => 'Depa 1',
        ]);

        $depa2 = Department::factory()->create([
            'name' => 'Depa 2',
        ]);

        $c1 = City::factory()->create([
            'name' => 'Ciudad 1',
            'department_id' => $depa1->id,
        ]);

        $c2 = City::factory()->create([
            'name' => 'Ciudad 2',
            'department_id' => $depa2->id,
        ]);

        $dis1 = District::factory()->create([
            'name' => 'Distrito 1',
            'city_id' => $c1->id,
        ]);

        $dis2 = District::factory()->create([
            'name' => 'Distrito 2',
            'city_id' => $c2->id,
        ]);

        $user1 = User::factory()->create();

        $this->post('/login', [
            'email' => $user1->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        Livewire::test(AddCartItem::class, ['product' => $p1])
            ->call('addItem');

        Livewire::test(CreateOrder::class)
            ->set('envio_type', 2)
            ->assertSee($depa1->name)
            ->assertSee($depa2->name)
            ->set('department_id', $depa1->id)
            ->assertSee($c1->name)
            ->assertDontSee($c2->name)
            ->set('city_id', $c1->id)
            ->assertSee($dis1->name)
            ->assertDontSee($dis2->name);
    }

    function createProduct($color = false, $size = false, $quantity = 5)
    {
        $category = Category::factory()->create();

        $subc1 = Subcategory::factory()->create([
            'category_id' => $category->id,
            'color' => $color,
            'size' => $size
        ]);

        $b1 = Brand::factory()->create();
        $category->brands()->attach($b1->id);

        $p1 = Product::factory()->create([
            'subcategory_id' => $subc1->id,
            'brand_id' => $b1->id,
            'quantity' => $quantity
        ]);

        Image::factory()->create([
            'imageable_id' => $p1->id,
            'imageable_type' => Product::class
        ]);

        if ($size && $color) {
            $p1->quantity = null;

            $pColor = Color::create([
                'name' => $color,
            ]);

            $pSize = $p1->sizes()->create([
                'name' => $size,
            ]);

            $pColor->sizes()->attach($pSize->id, ['quantity' => 1]);
        } elseif ($color && !$size) {
            $p1->quantity = null;

            $pColor = Color::create([
                'name' => $color,
            ]);

            $p1->colors()->attach($pColor->id, ['quantity' => 1]);
        }

        return $p1;
    }
}
