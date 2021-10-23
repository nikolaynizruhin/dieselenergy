<?php

namespace Tests\Feature\Admin\Order;

use App\Models\Order;
use Tests\TestCase;

class UpdateOrderTest extends TestCase
{
    /**
     * Product.
     *
     * @var \App\Models\Order
     */
    private $order;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->order = Order::factory()->create();
    }

    /** @test */
    public function guest_cant_visit_update_order_page()
    {
        $this->get(route('admin.orders.edit', $this->order))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_order_page()
    {
        $this->login()
            ->get(route('admin.orders.edit', $this->order))
            ->assertViewIs('admin.orders.edit')
            ->assertViewHas('order', $this->order)
            ->assertViewHas(['customers', 'statuses', 'products']);
    }

    /** @test */
    public function guest_cant_update_order()
    {
        $this->put(route('admin.orders.update', $this->order), $this->validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_order()
    {
        $this->login()
            ->put(route('admin.orders.update', $this->order), $fields = $this->validFields())
            ->assertRedirect(route('admin.orders.index'))
            ->assertSessionHas('status', trans('order.updated'));

        $this->assertDatabaseHas('orders', array_merge($fields, [
            'total' => $fields['total'] * 100,
        ]));
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_update_order_with_invalid_data($field, $data)
    {
        $this->login()
            ->from(route('admin.orders.edit', $this->order))
            ->put(route('admin.orders.update', $this->order), $data())
            ->assertRedirect(route('admin.orders.edit', $this->order))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('orders', 1);
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
                'customer_id', fn () => $this->validFields(['customer_id' => 10]),
            ],
            'Status is required' => [
                'status', fn () => $this->validFields(['status' => null]),
            ],
            'Status cant be an integer' => [
                'status', fn () => $this->validFields(['status' => 1]),
            ],
            'Total is required' => [
                'total', fn () => $this->validFields(['total' => null]),
            ],
            'Total cant be string' => [
                'total', fn () => $this->validFields(['total' => 'string']),
            ],
            'Total cant be negative' => [
                'total', fn () => $this->validFields(['total' => -1]),
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
        return Order::factory()->raw($overrides);
    }
}
