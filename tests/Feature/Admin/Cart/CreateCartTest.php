<?php

namespace Tests\Feature\Admin\Cart;

use App\Models\Cart;
use App\Models\Order;
use Tests\TestCase;

class CreateCartTest extends TestCase
{
    /** @test */
    public function guest_cant_visit_create_cart_page()
    {
        $order = Order::factory()->create();

        $this->get(route('admin.carts.create', ['order_id' => $order->id]))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_cart_page()
    {
        $order = Order::factory()->create();

        $this->login()
            ->get(route('admin.carts.create', ['order_id' => $order->id]))
            ->assertViewIs('admin.carts.create');
    }

    /** @test */
    public function guest_cant_create_cart()
    {
        $this->post(route('admin.carts.store'), $this->validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_cart()
    {
        $this->login()
            ->post(route('admin.carts.store'), $fields = $this->validFields())
            ->assertRedirect(route('admin.orders.show', $fields['order_id']))
            ->assertSessionHas('status', trans('cart.created'));

        $this->assertDatabaseHas('order_product', $fields);
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_create_cart_with_invalid_data($field, $data, $count = 0)
    {
        $this->login()
            ->from(route('admin.carts.create'))
            ->post(route('admin.carts.store'), $data())
            ->assertRedirect(route('admin.carts.create'))
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
                'product_id', fn () => $this->validFields(['product_id' => 1]),
            ],
            'Order is required' => [
                'order_id', fn () => $this->validFields(['order_id' => null]),
            ],
            'Order cant be string' => [
                'order_id', fn () => $this->validFields(['order_id' => 'string']),
            ],
            'Order must exists' => [
                'order_id', fn () => $this->validFields(['order_id' => 1]),
            ],
            'Cart must be unique' => [
                'product_id', fn () => Cart::factory()->create()->toArray(), 1,
            ],
        ];
    }

    /**
     * Get valid cart fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields($overrides = [])
    {
        return Cart::factory()->raw($overrides);
    }
}
