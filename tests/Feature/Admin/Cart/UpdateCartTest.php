<?php

namespace Tests\Feature\Admin\Cart;

use App\Models\Cart;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateCartTest extends TestCase
{
    /**
     * Product.
     *
     * @var \App\Models\Cart
     */
    private $cart;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->cart = Cart::factory()->create();
    }

    /** @test */
    public function guest_cant_visit_update_cart_page()
    {
        $this->get(route('admin.carts.edit', $this->cart))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_cart_page()
    {
        $this->login()
            ->get(route('admin.carts.edit', $this->cart))
            ->assertSuccessful()
            ->assertViewIs('admin.carts.edit')
            ->assertViewHas(['cart', 'products']);
    }

    /** @test */
    public function guest_cant_update_cart()
    {
        $this->put(route('admin.carts.update', $this->cart), $this->validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_cart()
    {
        $this->login()
            ->put(route('admin.carts.update', $this->cart), $fields = $this->validFields())
            ->assertRedirect(route('admin.orders.show', $fields['order_id']))
            ->assertSessionHas('status', trans('cart.updated'));

        $this->assertDatabaseHas('order_product', $fields);
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_update_cart_with_invalid_data($field, $data, $count = 1)
    {
        $this->login()
            ->from(route('admin.carts.edit', $this->cart))
            ->put(route('admin.carts.update', $this->cart), $data())
            ->assertRedirect(route('admin.carts.edit', $this->cart))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('order_product', $count);
    }

    public function validationProvider(): array
    {
        return [
            'Quantity is required' => [
                'quantity', fn () => $this->validFields(['quantity' => null]),
            ],
            'Quantity cant be a string' => [
                'quantity', fn () => $this->validFields(['quantity' => 'string']),
            ],
            'Quantity cant be zero' => [
                'quantity', fn () => $this->validFields(['quantity' => 0]),
            ],
            'Product is required' => [
                'product_id', fn () => $this->validFields(['product_id' => null]),
            ],
            'Product cant be string' => [
                'product_id', fn () => $this->validFields(['product_id' => 'string']),
            ],
            'Product must exists' => [
                'product_id', fn () => $this->validFields(['product_id' => 10]),
            ],
            'Order is required' => [
                'order_id', fn () => $this->validFields(['order_id' => null]),
            ],
            'Order cant be string' => [
                'order_id', fn () => $this->validFields(['order_id' => 'string']),
            ],
            'Order must exists' => [
                'order_id', fn () => $this->validFields(['order_id' => 10]),
            ],
            'Cart must be unique' => [
                'product_id', fn () => Cart::factory()->create()->toArray(), 2,
            ],
        ];
    }

    /**
     * Get valid contact fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields($overrides = [])
    {
        return Cart::factory()->raw($overrides);
    }
}
