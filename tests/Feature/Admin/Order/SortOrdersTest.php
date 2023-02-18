<?php

namespace Tests\Feature\Admin\Order;

use App\Enums\OrderStatus;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class SortOrdersTest extends TestCase
{
    /** @test */
    public function guest_cant_sort_orders(): void
    {
        $this->get(route('admin.orders.index', ['sort' => 'id']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_sort_orders_by_id_ascending(): void
    {
        [$adam, $tom] = Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['id' => 788365],
                ['id' => 987445],
            ))->create();

        $this->login()
            ->get(route('admin.orders.index', ['sort' => 'id']))
            ->assertSuccessful()
            ->assertViewIs('admin.orders.index')
            ->assertViewHas('orders')
            ->assertSeeInOrder([$adam->id, $tom->id]);
    }

    /** @test */
    public function admin_can_sort_orders_by_id_descending(): void
    {
        [$adam, $tom] = Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['id' => 788365],
                ['id' => 987445],
            ))->create();

        $this->login()
            ->get(route('admin.orders.index', ['sort' => '-id']))
            ->assertSuccessful()
            ->assertViewIs('admin.orders.index')
            ->assertViewHas('orders')
            ->assertSeeInOrder([$tom->id, $adam->id]);
    }

    /** @test */
    public function admin_can_sort_orders_by_status_ascending(): void
    {
        [$adam, $tom] = Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['status' => OrderStatus::Pending],
                ['status' => OrderStatus::New],
            ))->create();

        $this->login()
            ->get(route('admin.orders.index', ['sort' => 'status']))
            ->assertSuccessful()
            ->assertViewIs('admin.orders.index')
            ->assertViewHas('orders')
            ->assertSeeInOrder([$adam->status->value, $tom->status->value]);
    }

    /** @test */
    public function admin_can_sort_orders_by_status_descending(): void
    {
        [$adam, $tom] = Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['status' => OrderStatus::Pending],
                ['status' => OrderStatus::New],
            ))->create();

        $this->login()
            ->get(route('admin.orders.index', ['sort' => '-status']))
            ->assertSuccessful()
            ->assertViewIs('admin.orders.index')
            ->assertViewHas('orders')
            ->assertSeeInOrder([$tom->status->value, $adam->status->value]);
    }

    /** @test */
    public function admin_can_sort_orders_by_created_date_ascending(): void
    {
        [$adam, $tom] = Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['created_at' => now()],
                ['created_at' => now()->subDay()],
            ))->create();

        $this->login()
            ->get(route('admin.orders.index', ['sort' => 'created_at']))
            ->assertSuccessful()
            ->assertViewIs('admin.orders.index')
            ->assertViewHas('orders')
            ->assertSeeInOrder([$adam->id, $tom->id]);
    }

    /** @test */
    public function admin_can_sort_orders_by_created_date_descending(): void
    {
        [$adam, $tom] = Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['created_at' => now()],
                ['created_at' => now()->subDay()],
            ))->create();

        $this->login()
            ->get(route('admin.orders.index', ['sort' => '-created_at']))
            ->assertSuccessful()
            ->assertViewIs('admin.orders.index')
            ->assertViewHas('orders')
            ->assertSeeInOrder([$tom->id, $adam->id]);
    }

    /** @test */
    public function admin_can_sort_orders_by_total_ascending(): void
    {
        [$adam, $tom] = Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['total' => 100],
                ['total' => 200],
            ))->create();

        $this->login()
            ->get(route('admin.orders.index', ['sort' => 'total']))
            ->assertSuccessful()
            ->assertViewIs('admin.orders.index')
            ->assertViewHas('orders')
            ->assertSeeInOrder([$adam->id, $tom->id]);
    }

    /** @test */
    public function admin_can_sort_orders_by_total_descending(): void
    {
        [$adam, $tom] = Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['total' => 100],
                ['total' => 200],
            ))->create();

        $this->login()
            ->get(route('admin.orders.index', ['sort' => '-total']))
            ->assertSuccessful()
            ->assertViewIs('admin.orders.index')
            ->assertViewHas('orders')
            ->assertSeeInOrder([$tom->id, $adam->id]);
    }

    /** @test */
    public function admin_can_sort_orders_by_client_ascending(): void
    {
        [$adam, $tom] = Customer::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Adam'],
                ['name' => 'Tom'],
            ))->create();

        Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['id' => 788365, 'customer_id' => $adam],
                ['id' => 987445, 'customer_id' => $tom],
            ))->create();

        $this->login()
            ->get(route('admin.orders.index', ['sort' => 'customers.name']))
            ->assertSuccessful()
            ->assertViewIs('admin.orders.index')
            ->assertViewHas('orders')
            ->assertSeeInOrder([$adam->name, $tom->name]);
    }

    /** @test */
    public function admin_can_sort_orders_by_client_descending(): void
    {
        [$adam, $tom] = Customer::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Adam'],
                ['name' => 'Tom'],
            ))->create();

        Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['id' => 788365, 'customer_id' => $adam],
                ['id' => 987445, 'customer_id' => $tom],
            ))->create();

        $this->login()
            ->get(route('admin.orders.index', ['sort' => '-customers.name']))
            ->assertSuccessful()
            ->assertViewIs('admin.orders.index')
            ->assertViewHas('orders')
            ->assertSeeInOrder([$tom->name, $adam->name]);
    }
}
