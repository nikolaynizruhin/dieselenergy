<?php

namespace Tests\Feature\Cart;

use App\Models\Product;
use Facades\App\Services\Cart;
use Tests\TestCase;

class CreateCartTest extends TestCase
{
    /** @test */
    public function guest_can_add_product_to_cart()
    {
        $product = Product::factory()->withDefaultImage()->create();

        $this->from(route('categories.products.index', $product->category))
            ->post(route('carts.store', ['product_id' => $product->id, 'quantity' => 2]))
            ->assertRedirect(route('carts.index'))
            ->assertSessionHas('cart');

        $this->assertCount(1, $items = Cart::items());
        $this->assertEquals($product->id, $items->first()->id);
        $this->assertEquals(2, $items->first()->quantity);
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function guest_cant_create_cart_with_invalid_data($field, $data)
    {
        $this->post(route('carts.store', $data()))
            ->assertInvalid($field);

        $this->assertEmpty(Cart::items());
    }

    public function validationProvider(): array
    {
        return [
            'Product is required' => [
                'product_id', fn () => ['product_id' => null, 'quantity' => 1],
            ],
            'Product cant be a string' => [
                'product_id', fn () => ['product_id' => 'string', 'quantity' => 1],
            ],
            'Product must exists' => [
                'product_id', fn () => ['product_id' => 10, 'quantity' => 1],
            ],
            'Quantity is required' => [
                'quantity', fn () => ['product_id' => Product::factory()->create()->id, 'quantity' => null],
            ],
            'Quantity cant be a string' => [
                'quantity', fn () => ['product_id' => Product::factory()->create()->id, 'quantity' => 'string'],
            ],
            'Quantity cant be zero' => [
                'quantity', fn () => ['product_id' => Product::factory()->create()->id, 'quantity' => 0],
            ],
        ];
    }
}
