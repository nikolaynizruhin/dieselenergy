<?php

namespace Tests\Feature\Admin\Cart;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchCartsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_search_cart()
    {
        $user = User::factory()->create();

        [$patrol, $diesel, $waterPump] = Product::factory()
            ->count(3)
            ->state(new Sequence(
                ['name' => 'Patrol Generator'],
                ['name' => 'Diesel Generator'],
                ['name' => 'Water Pump'],
            ))->create();

        $order = Order::factory()->create();

        $order->products()->attach([$diesel->id, $patrol->id, $waterPump->id]);

        $this->actingAs($user)
            ->get(route('admin.orders.show', [
                'order' => $order,
                'search' => 'Generator',
            ]))->assertSuccessful()
            ->assertSeeInOrder([$diesel->name, $patrol->name])
            ->assertDontSee($waterPump->name);
    }
}
