<?php

namespace Tests\Feature\Cart;

use App\Models\Product;
use Facades\App\Cart\Cart;
use Tests\TestCase;

class UpdateCartTest extends TestCase
{
    /**
     * Product.
     *
     * @var \App\Models\Product
     */
    private $product;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->product = Product::factory()->withDefaultImage()->create();

        Cart::add($this->product, 1);
    }

    /** @test */
    public function guest_can_update_cart()
    {
        $this->put(route('carts.update', ['cart' => 0, 'quantity' => 3]))
            ->assertRedirect(route('carts.index'))
            ->assertSessionHas('cart');

        $this->assertCount(1, $items = Cart::items());
        $this->assertEquals($this->product->id, $items->first()->id);
        $this->assertEquals(3, $items->first()->quantity);
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function guest_cant_create_cart_with_invalid_data($quantity)
    {
        $this->put(route('carts.update', ['cart' => 0, 'quantity' => $quantity]))
            ->assertInvalid('quantity');
    }

    public function validationProvider(): array
    {
        return [
            'Quantity is required' => [null],
            'Quantity cant be a string' => ['string'],
            'Quantity cant be zero' => [0],
        ];
    }
}
