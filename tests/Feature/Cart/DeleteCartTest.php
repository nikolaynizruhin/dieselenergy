<?php

namespace Tests\Feature\Cart;

use App\Models\Image;
use App\Models\Product;
use Facades\App\Cart\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_delete_cart_item()
    {
        $image = Image::factory()->create();
        $product = Product::factory()->create();

        $product->images()->attach($image, ['is_default' => 1]);

        Cart::add($product);

        $this->from(route('carts.index'))
            ->delete(route('carts.destroy', 0))
            ->assertRedirect(route('carts.index'))
            ->assertSessionHas('status', trans('cart.deleted'));

        $this->assertCount(0, Cart::items());
    }
}
