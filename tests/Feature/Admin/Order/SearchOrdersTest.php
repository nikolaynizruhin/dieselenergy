<?php

namespace Tests\Feature\Admin\Order;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class SearchOrdersTest extends TestCase
{
    /** @test */
    public function guest_cant_search_orders()
    {
        $order = Order::factory()->create();

        $this->get(route('admin.orders.index', ['search' => $order->id]))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_orders()
    {
        [$orderA, $orderB, $orderC] = Order::factory()
            ->count(3)
            ->state(new Sequence(
                ['id' => 70613, 'created_at' => now()->subDay()],
                ['id' => 70614],
                ['id' => 70625],
            ))->create();

        $this->login()
            ->get(route('admin.orders.index', ['search' => '7061']))
            ->assertSeeInOrder([$orderB->id, $orderA->id])
            ->assertDontSee($orderC->id);
    }
}
