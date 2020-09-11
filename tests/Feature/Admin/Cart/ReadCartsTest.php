<?php

namespace Tests\Feature\Admin\Cart;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadCartsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function user_can_read_carts()
    {
        $user = User::factory()->create();

        $patrol = Product::factory()->create(['name' => 'Patrol']);
        $diesel = Product::factory()->create(['name' => 'Diesel']);

        $order = Order::factory()->create();

        $order->products()->attach([
            $patrol->id => ['quantity' => $this->faker->randomDigit],
            $diesel->id => ['quantity' => $this->faker->randomDigit],
        ]);

        $this->actingAs($user)
            ->get(route('admin.orders.show', $order))
            ->assertSuccessful()
            ->assertViewIs('admin.orders.show')
            ->assertViewHas('products')
            ->assertSeeInOrder([$diesel->name, $patrol->name]);
    }
}
