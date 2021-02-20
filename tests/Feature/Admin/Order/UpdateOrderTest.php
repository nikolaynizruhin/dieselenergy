<?php

namespace Tests\Feature\Admin\Order;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateOrderTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_update_order_page()
    {
        $order = Order::factory()->create();

        $this->get(route('admin.orders.edit', $order))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_order_page()
    {
        $order = Order::factory()->create();

        $this->login()
            ->get(route('admin.orders.edit', $order))
            ->assertViewIs('admin.orders.edit')
            ->assertViewHas('order', $order)
            ->assertViewHas(['customers', 'statuses', 'products']);
    }

    /** @test */
    public function guest_cant_update_order()
    {
        $order = Order::factory()->create();
        $stub = Order::factory()->raw();

        $this->put(route('admin.orders.update', $order), $stub)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_order()
    {
        $order = Order::factory()->create();
        $stub = Order::factory()->raw();

        $this->login()
            ->put(route('admin.orders.update', $order), $stub)
            ->assertRedirect(route('admin.orders.index'))
            ->assertSessionHas('status', trans('order.updated'));

        $this->assertDatabaseHas('orders', array_merge($stub, [
            'total' => $stub['total'] * 100,
        ]));
    }

    /** @test */
    public function user_cant_update_order_with_integer_notes()
    {
        $order = Order::factory()->create();
        $stub = Order::factory()->raw(['notes' => 1]);

        $this->login()
            ->put(route('admin.orders.update', $order), $stub)
            ->assertSessionHasErrors('notes');
    }

    /** @test */
    public function user_cant_update_order_without_customer()
    {
        $order = Order::factory()->create();
        $stub = Order::factory()->raw(['customer_id' => null]);

        $this->login()
            ->put(route('admin.orders.update', $order), $stub)
            ->assertSessionHasErrors('customer_id');
    }

    /** @test */
    public function user_cant_update_order_with_string_customer()
    {
        $order = Order::factory()->create();
        $stub = Order::factory()->raw(['customer_id' => 'string']);

        $this->login()
            ->put(route('admin.orders.update', $order), $stub)
            ->assertSessionHasErrors('customer_id');
    }

    /** @test */
    public function user_cant_update_order_with_nonexistent_customer()
    {
        $order = Order::factory()->create();
        $stub = Order::factory()->raw(['customer_id' => 10]);

        $this->login()
            ->put(route('admin.orders.update', $order), $stub)
            ->assertSessionHasErrors('customer_id');
    }

    /** @test */
    public function user_cant_update_order_without_status()
    {
        $order = Order::factory()->create();
        $stub = Order::factory()->raw(['status' => null]);

        $this->login()
            ->put(route('admin.orders.update', $order), $stub)
            ->assertSessionHasErrors('status');
    }

    /** @test */
    public function user_cant_update_order_with_integer_status()
    {
        $order = Order::factory()->create();
        $stub = Order::factory()->raw(['status' => 1]);

        $this->login()
            ->put(route('admin.orders.update', $order), $stub)
            ->assertSessionHasErrors('status');
    }

    /** @test */
    public function user_cant_update_product_without_total()
    {
        $order = Order::factory()->create();
        $stub = Order::factory()->raw(['total' => null]);

        $this->login()
            ->put(route('admin.orders.update', $order), $stub)
            ->assertSessionHasErrors('total');
    }

    /** @test */
    public function user_cant_update_product_with_string_total()
    {
        $order = Order::factory()->create();
        $stub = Order::factory()->raw(['total' => 'string']);

        $this->login()
            ->put(route('admin.orders.update', $order), $stub)
            ->assertSessionHasErrors('total');
    }

    /** @test */
    public function user_cant_update_product_with_negative_total()
    {
        $order = Order::factory()->create();
        $stub = Order::factory()->raw(['total' => -1]);

        $this->login()
            ->put(route('admin.orders.update', $order), $stub)
            ->assertSessionHasErrors('total');
    }
}
