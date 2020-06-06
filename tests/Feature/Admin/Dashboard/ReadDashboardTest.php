<?php

namespace Tests\Feature\Admin\Dashboard;

use App\Customer;
use App\Order;
use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadDashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_dashboard()
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_dashboard()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        $orderA = factory(Order::class)->create(['created_at' => now()]);
        $orderB = factory(Order::class)->create(['created_at' => now()->subDay()]);

        $orderA->products()->attach($product, ['quantity' => 2]);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertSuccessful()
            ->assertViewIs('admin.dashboard')
            ->assertViewHas('orders')
            ->assertViewHas('totalOrders', 2)
            ->assertViewHas('totalCustomers', 2)
            ->assertViewHas('soldProducts', 2)
            ->assertSeeInOrder([$orderA->status, $orderB->status]);
    }

    /** @test */
    public function user_can_search_dashboard_orders()
    {
        $user = factory(User::class)->create();

        $jane = factory(Customer::class)->create(['name' => 'Jane Doe']);
        factory(Order::class)->create(['customer_id' => $jane->id, 'created_at' => now()->subDay()]);

        $john = factory(Customer::class)->create(['name' => 'John Doe']);
        factory(Order::class)->create(['customer_id' => $john->id, 'created_at' => now()]);

        $tom = factory(Customer::class)->create(['name' => 'Tom Jo']);
        factory(Order::class)->create(['customer_id' => $jane->id]);

        $this->actingAs($user)
            ->get(route('admin.dashboard', ['search' => 'Doe']))
            ->assertSeeInOrder([$john->name, $jane->name])
            ->assertDontSee($tom->name);
    }
}
