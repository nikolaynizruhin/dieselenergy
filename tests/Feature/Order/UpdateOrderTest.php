<?php

namespace Tests\Feature\Order;

use App\Order;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateOrderTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_update_order_page()
    {
        $order = factory(Order::class)->create();

        $this->get(route('orders.edit', $order))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_visit_update_order_page()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->create();

        $this->actingAs($user)
            ->get(route('orders.edit', $order))
            ->assertViewIs('orders.edit')
            ->assertViewHas('order', $order)
            ->assertViewHas(['customers', 'statuses', 'products']);
    }

    /** @test */
    public function guest_cant_update_order()
    {
        $order = factory(Order::class)->create();
        $stub = factory(Order::class)->raw();

        $this->put(route('orders.update', $order), $stub)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_update_order()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->create();
        $stub = factory(Order::class)->raw();

        $this->actingAs($user)
            ->put(route('orders.update', $order), $stub)
            ->assertRedirect(route('orders.index'))
            ->assertSessionHas('status', 'Order was updated successfully!');

        $this->assertDatabaseHas('orders', $stub);
    }

    /** @test */
    public function user_cant_update_order_with_integer_notes()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->create();
        $stub = factory(Order::class)->raw(['notes' => 1]);

        $this->actingAs($user)
            ->put(route('orders.update', $order), $stub)
            ->assertSessionHasErrors('notes');
    }

    /** @test */
    public function user_cant_update_order_without_customer()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->create();
        $stub = factory(Order::class)->raw(['customer_id' => null]);

        $this->actingAs($user)
            ->put(route('orders.update', $order), $stub)
            ->assertSessionHasErrors('customer_id');
    }

    /** @test */
    public function user_cant_update_order_with_string_customer()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->create();
        $stub = factory(Order::class)->raw(['customer_id' => 'string']);

        $this->actingAs($user)
            ->put(route('orders.update', $order), $stub)
            ->assertSessionHasErrors('customer_id');
    }

    /** @test */
    public function user_cant_update_order_with_nonexistent_customer()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->create();
        $stub = factory(Order::class)->raw(['customer_id' => 10]);

        $this->actingAs($user)
            ->put(route('orders.update', $order), $stub)
            ->assertSessionHasErrors('customer_id');
    }

    /** @test */
    public function user_cant_update_order_without_status()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->create();
        $stub = factory(Order::class)->raw(['status' => null]);

        $this->actingAs($user)
            ->put(route('orders.update', $order), $stub)
            ->assertSessionHasErrors('status');
    }

    /** @test */
    public function user_cant_update_order_with_integer_status()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->create();
        $stub = factory(Order::class)->raw(['status' => 1]);

        $this->actingAs($user)
            ->put(route('orders.update', $order), $stub)
            ->assertSessionHasErrors('status');
    }

    /** @test */
    public function user_cant_update_product_without_total()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->create();
        $stub = factory(Order::class)->raw(['total' => null]);

        $this->actingAs($user)
            ->put(route('orders.update', $order), $stub)
            ->assertSessionHasErrors('total');
    }

    /** @test */
    public function user_cant_update_product_with_string_total()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->create();
        $stub = factory(Order::class)->raw(['total' => 'string']);

        $this->actingAs($user)
            ->put(route('orders.update', $order), $stub)
            ->assertSessionHasErrors('total');
    }

    /** @test */
    public function user_cant_update_product_with_negative_total()
    {
        $user = factory(User::class)->create();
        $order = factory(Order::class)->create();
        $stub = factory(Order::class)->raw(['total' => -1]);

        $this->actingAs($user)
            ->put(route('orders.update', $order), $stub)
            ->assertSessionHasErrors('total');
    }
}
