<?php

namespace Tests\Feature\Cart;

use App\Image;
use App\Product;
use Facades\App\Cart\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadCartsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_read_carts()
    {
        $image = factory(Image::class)->create();
        $product = factory(Product::class)->create();

        $product->images()->attach($image, ['is_default' => 1]);

        Cart::add($product);

        $this->get(route('carts.index'))
            ->assertSuccessful()
            ->assertSee($product->name);
    }
}
