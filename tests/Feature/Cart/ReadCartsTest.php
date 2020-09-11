<?php

namespace Tests\Feature\Cart;

use App\Models\Image;
use App\Models\Product;
use Facades\App\Cart\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadCartsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_read_carts()
    {
        $image = Image::factory()->create();
        $product = Product::factory()->create();

        $product->images()->attach($image, ['is_default' => 1]);

        Cart::add($product);

        $this->get(route('carts.index'))
            ->assertSuccessful()
            ->assertSee($product->name);
    }
}
