<?php

namespace Tests\Feature\Admin\Order;

use App\Models\Order;
use App\Models\User;
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
        $user = User::factory()->create();
        $order = Order::factory()->create();

        $this->actingAs($user)
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
        $user = User::factory()->create();
        $order = Order::factory()->create();
        $stub = Order::factory()->raw();

        $this->actingAs($user)
            ->put(route('admin.orders.update', $order), $stub)
            ->assertRedirect(route('admin.orders.index'))
            ->assertSessionHas('status', trans('order.updated'));

        $this->assertDatabaseHas('orders', $stub);
    }

    /** @test */
    public function user_cant_update_order_with_integer_notes()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create();
        $stub = Order::factory()->raw(['notes' => 1]);

        $this->actingAs($user)
            ->put(route('admin.orders.update', $order), $stub)
            ->assertSessionHasErrors('notes');
    }

    /** @test */
    public function user_cant_update_order_without_customer()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create();
        $stub = Order::factory()->raw(['customer_id' => null]);

        $this->actingAs($user)
            ->put(route('admin.orders.update', $order), $stub)
            ->assertSessionHasErrors('customer_id');
    }

    /** @test */
    public function user_cant_update_order_with_string_customer()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create();
        $stub = Order::factory()->raw(['customer_id' => 'string']);

        $this->actingAs($user)
            ->put(route('admin.orders.update', $order), $stub)
            ->assertSessionHasErrors('customer_id');
    }

    /** @test */
    public function user_cant_update_order_with_nonexistent_customer()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create();
        $stub = Order::factory()->raw(['customer_id' => 10]);

        $this->actingAs($user)
            ->put(route('admin.orders.update', $order), $stub)
            ->assertSessionHasErrors('customer_id');
    }

    /** @test */
    public function user_cant_update_order_without_status()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create();
        $stub = Order::factory()->raw(['status' => null]);

        $this->actingAs($user)
            ->put(route('admin.orders.update', $order), $stub)
            ->assertSessionHasErrors('status');
    }

    /** @test */
    public function user_cant_update_order_with_integer_status()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create();
        $stub = Order::factory()->raw(['status' => 1]);

        $this->actingAs($user)
            ->put(route('admin.orders.update', $order), $stub)
            ->assertSessionHasErrors('status');
    }

    /** @test */
    public function user_cant_update_product_without_total()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create();
        $stub = Order::factory()->raw(['total' => null]);

        $this->actingAs($user)
            ->put(route('admin.orders.update', $order), $stub)
            ->assertSessionHasErrors('total');
    }

    /** @test */
    public function user_cant_update_product_with_string_total()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create();
        $stub = Order::factory()->raw(['total' => 'string']);

        $this->actingAs($user)
            ->put(route('admin.orders.update', $order), $stub)
            ->assertSessionHasErrors('total');
    }

    /** @test */
    public function user_cant_update_product_with_negative_total()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create();
        $stub = Order::factory()->raw(['total' => -1]);

        $this->actingAs($user)
            ->put(route('admin.orders.update', $order), $stub)
            ->assertSessionHasErrors('total');
    }
}
