<?php

namespace Tests\Feature\Dashboard;

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
        $this->get(route('dashboard'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_read_dashboard()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        [$orderA, $orderB] = factory(Order::class, 2)->create();

        $orderA->products()->attach($product, ['quantity' => 2]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertSuccessful()
            ->assertViewIs('dashboard')
            ->assertViewHas('orders')
            ->assertViewHas('totalOrders', 2)
            ->assertViewHas('totalCustomers', 2)
            ->assertViewHas('soldProducts', 2)
            ->assertSee($orderA->status)
            ->assertSee($orderB->status);
    }
}
