<?php

namespace Tests\Feature\Admin\Order;

use App\Order;
use App\User;
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
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get(route('admin.orders.create'))
            ->assertViewIs('admin.orders.create')
            ->assertViewHas(['products', 'customers', 'statuses']);
    }

    /** @test */
    public function guest_cant_create_product()
    {
        $order = factory(Order::class)->raw();

        $this->post(route('admin.orders.store'), $order)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_order()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->raw(['total' => 0]);

        $this->actingAs($user)
            ->post(route('admin.orders.store'), $order)
            ->assertRedirect(route('admin.orders.index'))
            ->assertSessionHas('status', trans('order.created'));

        $this->assertDatabaseHas('orders', $order);
    }

    /** @test */
    public function user_cant_create_order_with_integer_notes()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->raw(['notes' => 1]);

        $this->actingAs($user)
            ->post(route('admin.orders.store'), $order)
            ->assertSessionHasErrors('notes');
    }

    /** @test */
    public function user_cant_create_order_without_customer()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->raw(['customer_id' => null]);

        $this->actingAs($user)
            ->post(route('admin.orders.store'), $order)
            ->assertSessionHasErrors('customer_id');
    }

    /** @test */
    public function user_cant_create_order_with_string_customer()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->raw(['customer_id' => 'string']);

        $this->actingAs($user)
            ->post(route('admin.orders.store'), $order)
            ->assertSessionHasErrors('customer_id');
    }

    /** @test */
    public function user_cant_create_order_with_nonexistent_customer()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->raw(['customer_id' => 1]);

        $this->actingAs($user)
            ->post(route('admin.orders.store'), $order)
            ->assertSessionHasErrors('customer_id');
    }

    /** @test */
    public function user_cant_create_order_without_status()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->raw(['status' => null]);

        $this->actingAs($user)
            ->post(route('admin.orders.store'), $order)
            ->assertSessionHasErrors('status');
    }

    /** @test */
    public function user_cant_create_order_with_integer_status()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->raw(['status' => 1]);

        $this->actingAs($user)
            ->post(route('admin.orders.store'), $order)
            ->assertSessionHasErrors('status');
    }
}
