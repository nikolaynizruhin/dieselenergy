<?php

namespace Tests\Feature\Admin\Cart;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchCartsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_search_cart()
    {
        $user = User::factory()->create();

        $patrol = Product::factory()->create(['name' => 'Patrol Generator']);
        $diesel = Product::factory()->create(['name' => 'Diesel Generator']);
        $waterPump = Product::factory()->create(['name' => 'Water Pump']);

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
