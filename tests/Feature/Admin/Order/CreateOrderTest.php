<?php

namespace Tests\Feature\Admin\Order;

use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use HasValidation;

    /** @test */
    public function guest_cant_visit_create_order_page(): void
    {
        $this->get(route('admin.orders.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_order_page(): void
    {
        $this->login()
            ->get(route('admin.orders.create'))
            ->assertViewIs('admin.orders.create')
            ->assertViewHas(['products', 'customers', 'statuses']);
    }

    /** @test */
    public function guest_cant_create_product(): void
    {
        $this->post(route('admin.orders.store'), self::validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_order(): void
    {
        $this->login()
            ->post(route('admin.orders.store'), $fields = self::validFields(['total' => 0]))
            ->assertRedirect(route('admin.orders.index'))
            ->assertSessionHas('status', trans('order.created'));

        $this->assertDatabaseHas('orders', $fields);
    }

    /**
     * @test
     *
     * @dataProvider provider
     */
    public function user_cant_create_order_with_invalid_data(string $field, callable $data, int $count = 0): void
    {
        $this->login()
            ->from(route('admin.orders.create'))
            ->post(route('admin.orders.store'), $data())
            ->assertRedirect(route('admin.orders.create'))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('orders', $count);
    }
}
