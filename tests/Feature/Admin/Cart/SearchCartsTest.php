<?php

namespace Tests\Feature\Admin\Cart;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class SearchCartsTest extends TestCase
{
    /** @test */
    public function guest_cant_search_cart(): void
    {
        $product = Product::factory()->create(['name' => 'Diesel Generator']);

        $order = Order::factory()->create();

        $order->products()->attach([$product->id]);

        $this->get(route('admin.orders.show', [
            'order' => $order,
            'search' => 'Diesel',
        ]))->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_cart(): void
    {
        [$patrol, $diesel, $waterPump] = Product::factory()
            ->count(3)
            ->state(new Sequence(
                ['name' => 'Patrol Generator'],
                ['name' => 'Diesel Generator'],
                ['name' => 'Water Pump'],
            ))->create();

        $order = Order::factory()->create();

        $order->products()->attach([$diesel->id, $patrol->id, $waterPump->id]);

        $this->login()
            ->get(route('admin.orders.show', [
                'order' => $order,
                'search' => 'Generator',
            ]))->assertSuccessful()
            ->assertSeeInOrder([$diesel->name, $patrol->name])
            ->assertDontSee($waterPump->name);
    }
}
