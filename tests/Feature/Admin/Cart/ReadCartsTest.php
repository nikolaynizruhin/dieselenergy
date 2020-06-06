<?php

namespace Tests\Feature\Admin\Cart;

use App\Order;
use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadCartsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function user_can_read_carts()
    {
        $user = factory(User::class)->create();

        $patrol = factory(Product::class)->create(['name' => 'Patrol']);
        $diesel = factory(Product::class)->create(['name' => 'Diesel']);

        $order = factory(Order::class)->create();

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
