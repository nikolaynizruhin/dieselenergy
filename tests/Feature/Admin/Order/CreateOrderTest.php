<?php

namespace Tests\Feature\Admin\Order;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_visit_create_order_page()
    {
        $this->get(route('admin.orders.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_order_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.orders.create'))
            ->assertViewIs('admin.orders.create')
            ->assertViewHas(['products', 'customers', 'statuses']);
    }

    /** @test */
    public function guest_cant_create_product()
    {
        $order = Order::factory()->make()->toArray();

        $this->post(route('admin.orders.store'), $order)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_order()
    {
        $user = User::factory()->create();
        $order = Order::factory()->make(['total' => 0])->toArray();

        $this->actingAs($user)
            ->post(route('admin.orders.store'), $order)
            ->assertRedirect(route('admin.orders.index'))
            ->assertSessionHas('status', trans('order.created'));

        $this->assertDatabaseHas('orders', $order);
    }

    /** @test */
    public function user_cant_create_order_with_integer_notes()
    {
        $user = User::factory()->create();
        $order = Order::factory()->make(['notes' => 1])->toArray();

        $this->actingAs($user)
            ->post(route('admin.orders.store'), $order)
            ->assertSessionHasErrors('notes');
    }

    /** @test */
    public function user_cant_create_order_without_customer()
    {
        $user = User::factory()->create();
        $order = Order::factory()->make(['customer_id' => null])->toArray();

        $this->actingAs($user)
            ->post(route('admin.orders.store'), $order)
            ->assertSessionHasErrors('customer_id');
    }

    /** @test */
    public function user_cant_create_order_with_string_customer()
    {
        $user = User::factory()->create();
        $order = Order::factory()->make(['customer_id' => 'string'])->toArray();

        $this->actingAs($user)
            ->post(route('admin.orders.store'), $order)
            ->assertSessionHasErrors('customer_id');
    }

    /** @test */
    public function user_cant_create_order_with_nonexistent_customer()
    {
        $user = User::factory()->create();
        $order = Order::factory()->make(['customer_id' => 1])->toArray();

        $this->actingAs($user)
            ->post(route('admin.orders.store'), $order)
            ->assertSessionHasErrors('customer_id');
    }

    /** @test */
    public function user_cant_create_order_without_status()
    {
        $user = User::factory()->create();
        $order = Order::factory()->make(['status' => null])->toArray();

        $this->actingAs($user)
            ->post(route('admin.orders.store'), $order)
            ->assertSessionHasErrors('status');
    }

    /** @test */
    public function user_cant_create_order_with_integer_status()
    {
        $user = User::factory()->create();
        $order = Order::factory()->make(['status' => 1])->toArray();

        $this->actingAs($user)
            ->post(route('admin.orders.store'), $order)
            ->assertSessionHasErrors('status');
    }
}
