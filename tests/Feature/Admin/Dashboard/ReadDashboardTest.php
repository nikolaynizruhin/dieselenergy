<?php

namespace Tests\Feature\Admin\Dashboard;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class ReadDashboardTest extends TestCase
{
    /** @test */
    public function guest_cant_read_dashboard()
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_dashboard()
    {
        $product = Product::factory()->create();

        [$orderA, $orderB] = Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['created_at' => now()],
                ['created_at' => now()->subDay()],
            ))->create();

        $orderA->products()->attach($product, ['quantity' => 2]);

        $this->login()
            ->get(route('admin.dashboard'))
            ->assertSuccessful()
            ->assertViewIs('admin.dashboard')
            ->assertViewHas('orders')
            ->assertViewHas('totalCustomers', 2)
            ->assertViewHas('soldProducts', 2)
            ->assertSeeInOrder([$orderA->status, $orderB->status]);
    }
}
