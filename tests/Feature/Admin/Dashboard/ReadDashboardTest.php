<?php

namespace Tests\Feature\Admin\Dashboard;

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
}
