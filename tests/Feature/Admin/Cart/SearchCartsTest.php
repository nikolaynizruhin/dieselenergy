<?php

namespace Tests\Feature\Admin\Cart;

use App\Order;
use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchCartsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_search_cart()
    {
        $user = factory(User::class)->create();

        $patrol = factory(Product::class)->create(['name' => 'Patrol Generator']);
        $diesel = factory(Product::class)->create(['name' => 'Diesel Generator']);
        $waterPump = factory(Product::class)->create(['name' => 'Water Pump']);

        $order = factory(Order::class)->create();

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
