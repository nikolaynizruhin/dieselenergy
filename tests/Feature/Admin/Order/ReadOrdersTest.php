<?php

namespace Tests\Feature\Admin\Order;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadOrdersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_orders()
    {
        $this->get(route('admin.orders.index'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_orders()
    {
        $user = User::factory()->create();

        $orderB = Order::factory()->create(['created_at' => now()->subDay()]);
        $orderA = Order::factory()->create(['created_at' => now()]);

        $this->actingAs($user)
            ->get(route('admin.orders.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.orders.index')
            ->assertViewHas('orders')
            ->assertSeeInOrder([$orderA->status, $orderB->status]);
    }
}
