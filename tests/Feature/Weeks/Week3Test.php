<?php

namespace Tests\Feature\Weeks;

use App\Http\Livewire\AddCartItem;
use App\Http\Livewire\AddCartItemColor;
use App\Http\Livewire\AddCartItemSize;
use App\Http\Livewire\DropdownCart;
use App\Models\{Brand, Category, Color, Image, Product, Size, Subcategory};
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
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

        $this->assertEquals($p1->id, Cart::content()->first()->id);
        $this->assertNotEquals($p2->id, Cart::content()->first()->id);
    }

    /** @test */
    function a_product_with_color_but_without_size_is_added_to_the_shopping_cart()
    {
        $p1 = $this->createProduct(true);
        $p2 = $this->createProduct();

        Livewire::test(AddCartItemColor::class, ['product' => $p1])
            ->call('addItem', $p1)
            ->assertStatus(200);

        $this->assertEquals($p1->id, Cart::content()->first()->id);
        $this->assertNotEquals($p2->id, Cart::content()->first()->id);
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

        $this->assertEquals($p1->id, Cart::content()->first()->id);
        $this->assertNotEquals($p2->id, Cart::content()->first()->id);
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
    function it_is_not_possible_to_add_more_products_than_the_total_stock_to_the_shopping_cart()
    {
        $quantity = 2;
        $p1 = $this->createProduct(false, false, $quantity);


        Livewire::test(AddCartItem::class, ['product' => $p1])
            ->set('qty', 2)
            ->call('addItem', $p1);


        Livewire::test(DropdownCart::class)
            ->assertSee($p1->price)
            ->assertSee($p1->name);
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
