<?php

namespace Tests\Feature\Admin\Order;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchOrdersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_orders()
    {
        $order = Order::factory()->create();

        $this->get(route('admin.orders.index', ['search' => $order->customer->name]))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_orders()
    {
        $user = User::factory()->create();

        $jane = Customer::factory()->create(['name' => 'Jane Doe']);
        Order::factory()->create(['customer_id' => $jane->id, 'created_at' => now()->subDay()]);

        $john = Customer::factory()->create(['name' => 'John Doe']);
        Order::factory()->create(['customer_id' => $john->id, 'created_at' => now()]);

        $tom = Customer::factory()->create(['name' => 'Tom Jo']);
        Order::factory()->create(['customer_id' => $jane->id]);

        $this->actingAs($user)
            ->get(route('admin.orders.index', ['search' => 'Doe']))
            ->assertSeeInOrder([$john->name, $jane->name])
            ->assertDontSee($tom->name);
    }
}
