<?php

namespace Tests\Feature\Cart;

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
        $product = factory(Product::class)->create();

        Cart::add($product);

        $this->get(route('carts.index'))
            ->assertSuccessful()
            ->assertSee($product->name);
    }
}
