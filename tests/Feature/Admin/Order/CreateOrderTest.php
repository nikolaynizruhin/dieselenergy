<?php

namespace Tests\Feature\Admin\Order;

use App\Models\Order;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    /** @test */
    public function guest_cant_visit_create_order_page()
    {
        $this->get(route('admin.orders.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_order_page()
    {
        $this->login()
            ->get(route('admin.orders.create'))
            ->assertViewIs('admin.orders.create')
            ->assertViewHas(['products', 'customers', 'statuses']);
    }

    /** @test */
    public function guest_cant_create_product()
    {
        $this->post(route('admin.orders.store'), $this->validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_order()
    {
        $this->login()
            ->post(route('admin.orders.store'), $fields = $this->validFields(['total' => 0]))
            ->assertRedirect(route('admin.orders.index'))
            ->assertSessionHas('status', trans('order.created'));

        $this->assertDatabaseHas('orders', $fields);
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_create_order_with_invalid_data($field, $data, $count = 0)
    {
        $this->login()
            ->from(route('admin.orders.create'))
            ->post(route('admin.orders.store'), $data())
            ->assertRedirect(route('admin.orders.create'))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('orders', $count);
    }

    public function validationProvider(): array
    {
        return [
            'Notes cant be an integer' => [
                'notes', fn () => $this->validFields(['notes' => 1]),
            ],
            'Customer is required' => [
                'customer_id', fn () => $this->validFields(['customer_id' => null]),
            ],
            'Customer cant be string' => [
                'customer_id', fn () => $this->validFields(['customer_id' => 'string']),
            ],
            'Customer must exists' => [
                'customer_id', fn () => $this->validFields(['customer_id' => 1]),
            ],
            'Status is required' => [
                'status', fn () => $this->validFields(['status' => null]),
            ],
            'Status cant be an integer' => [
                'status', fn () => $this->validFields(['status' => 1]),
            ],
        ];
    }

    /**
     * Get valid order fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields($overrides = [])
    {
        return Order::factory()->raw($overrides);
    }
}
