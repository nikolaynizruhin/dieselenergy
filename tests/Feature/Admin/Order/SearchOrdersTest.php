<?php

namespace Tests\Feature\Admin\Order;

use App\Customer;
use App\Order;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchOrdersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_orders()
    {
        $order = factory(Order::class)->create();

        $this->get(route('admin.orders.index', ['search' => $order->customer->name]))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_orders()
    {
        $user = factory(User::class)->create();

        $jane = factory(Customer::class)->create(['name' => 'Jane Doe']);
        factory(Order::class)->create(['customer_id' => $jane->id, 'created_at' => now()->subDay()]);

        $john = factory(Customer::class)->create(['name' => 'John Doe']);
        factory(Order::class)->create(['customer_id' => $john->id, 'created_at' => now()]);

        $tom = factory(Customer::class)->create(['name' => 'Tom Jo']);
        factory(Order::class)->create(['customer_id' => $jane->id]);

        $this->actingAs($user)
            ->get(route('admin.orders.index', ['search' => 'Doe']))
            ->assertSeeInOrder([$john->name, $jane->name])
            ->assertDontSee($tom->name);
    }
}
