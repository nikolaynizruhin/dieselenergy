<?php

namespace Tests\Feature\Cart;

use App\Models\Product;
use Facades\App\Cart\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadCartsTest extends TestCase
{


    /** @test */
    public function guest_can_read_carts()
    {
        $product = Product::factory()->withDefaultImage()->create();

        Cart::add($product);

        $this->get(route('carts.index'))
            ->assertSuccessful()
            ->assertSee($product->name);
    }
}
