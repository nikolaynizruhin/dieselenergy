<?php

namespace Tests\Feature\Admin\Order;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortOrdersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_sort_orders()
    {
        $this->get(route('admin.orders.index', ['sort' => 'id']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_sort_orders_ascending()
    {
        $user = User::factory()->create();

        [$adam, $tom] = Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['id' => 788365],
                ['id' => 987445],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.orders.index', ['sort' => 'id']))
            ->assertSuccessful()
            ->assertViewIs('admin.orders.index')
            ->assertViewHas('orders')
            ->assertSeeInOrder([$adam->id, $tom->id]);
    }

    /** @test */
    public function admin_can_sort_orders_descending()
    {
        $user = User::factory()->create();

        [$adam, $tom] = Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['id' => 788365],
                ['id' => 987445],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.orders.index', ['sort' => '-id']))
            ->assertSuccessful()
            ->assertViewIs('admin.orders.index')
            ->assertViewHas('orders')
            ->assertSeeInOrder([$tom->id, $adam->id]);
    }

    /** @test */
    public function admin_can_sort_orders_by_client_ascending()
    {
        $user = User::factory()->create();

        [$adam, $tom] = Customer::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Adam'],
                ['name' => 'Tom'],
            ))->create();

        Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['id' => 788365, 'customer_id' => $adam->id],
                ['id' => 987445, 'customer_id' => $tom->id],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.orders.index', ['sort' => 'customers.name']))
            ->assertSuccessful()
            ->assertViewIs('admin.orders.index')
            ->assertViewHas('orders')
            ->assertSeeInOrder([$adam->name, $tom->name]);
    }

    /** @test */
    public function admin_can_sort_orders_by_client_descending()
    {
        $user = User::factory()->create();

        [$adam, $tom] = Customer::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Adam'],
                ['name' => 'Tom'],
            ))->create();

        Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['id' => 788365, 'customer_id' => $adam->id],
                ['id' => 987445, 'customer_id' => $tom->id],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.orders.index', ['sort' => '-customers.name']))
            ->assertSuccessful()
            ->assertViewIs('admin.orders.index')
            ->assertViewHas('orders')
            ->assertSeeInOrder([$tom->name, $adam->name]);
    }
}
