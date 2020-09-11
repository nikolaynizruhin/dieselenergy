<?php

namespace Tests\Feature\Admin\Dashboard;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchOrdersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_orders()
    {
        $order = Order::factory()->create();

        $this->get(route('admin.dashboard', ['search' => $order->customer->name]))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_dashboard_orders()
    {
        $user = User::factory()->create();

        [$jane, $john, $tom] = Customer::factory()
            ->count(3)
            ->state(new Sequence(
                ['name' => 'Jane Doe'],
                ['name' => 'John Doe'],
                ['name' => 'Tom Jo'],
            ))->create();

        Order::factory()
            ->count(3)
            ->state(new Sequence(
                ['customer_id' => $jane->id, 'created_at' => now()->subDay()],
                ['customer_id' => $john->id],
                ['customer_id' => $jane->id],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.dashboard', ['search' => 'Doe']))
            ->assertSeeInOrder([$john->name, $jane->name])
            ->assertDontSee($tom->name);
    }
}
