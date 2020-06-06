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

        $diesel = factory(Product::class)->create(['name' => 'Diesel']);
        $patrol = factory(Product::class)->create(['name' => 'Patrol']);

        $order = factory(Order::class)->create();

        $order->products()->attach([$diesel->id, $patrol->id]);

        $this->actingAs($user)
            ->get(route('admin.orders.show', [
                'order' => $order,
                'search' => $diesel->name,
            ]))->assertSuccessful()
            ->assertSee($diesel->name)
            ->assertDontSee($patrol->name);
    }
}
