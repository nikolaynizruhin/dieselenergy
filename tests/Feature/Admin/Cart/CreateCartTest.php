<?php

namespace Tests\Feature\Admin\Cart;

use App\Models\Order;
use Tests\TestCase;

class CreateCartTest extends TestCase
{
    use HasValidation;

    /** @test */
    public function guest_cant_visit_create_cart_page(): void
    {
        $order = Order::factory()->create();

        $this->get(route('admin.carts.create', ['order_id' => $order->id]))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_cart_page(): void
    {
        $order = Order::factory()->create();

        $this->login()
            ->get(route('admin.carts.create', ['order_id' => $order->id]))
            ->assertViewIs('admin.carts.create');
    }

    /** @test */
    public function guest_cant_create_cart(): void
    {
        $this->post(route('admin.carts.store'), self::validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_cart(): void
    {
        $this->login()
            ->post(route('admin.carts.store'), $fields = self::validFields())
            ->assertRedirect(route('admin.orders.show', $fields['order_id']))
            ->assertSessionHas('status', trans('cart.created'));

        $this->assertDatabaseHas('order_product', $fields);
    }

    /**
     * @test
     *
     * @dataProvider validationProvider
     */
    public function user_cant_create_cart_with_invalid_data(string $field, callable $data, int $count = 0): void
    {
        $this->login()
            ->from(route('admin.carts.create'))
            ->post(route('admin.carts.store'), $data())
            ->assertRedirect(route('admin.carts.create'))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('order_product', $count);
    }

    public static function validationProvider(): array
    {
        return self::provider();
    }
}
