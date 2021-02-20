<?php

namespace Tests\Feature\Admin\Dashboard;

use App\Models\Order;
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

        $this->get(route('admin.dashboard', ['search' => $order->id]))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_dashboard_orders()
    {
        [$orderA, $orderB, $orderC] = Order::factory()
            ->count(3)
            ->state(new Sequence(
                ['id' => 70613, 'created_at' => now()->subDay()],
                ['id' => 70614],
                ['id' => 70625],
            ))->create();

        $this->login()
            ->get(route('admin.dashboard', ['search' => '7061']))
            ->assertSeeInOrder([$orderB->id, $orderA->id])
            ->assertDontSee($orderC->id);
    }
}
