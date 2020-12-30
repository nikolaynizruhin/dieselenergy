<?php

namespace Tests\Feature\Admin\Cart;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortCartsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Order.
     *
     * @var \App\Models\Order
     */
    private $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->order = Order::factory()->create();
    }

    /** @test */
    public function guest_cant_sort_carts()
    {
        $this->get(route('admin.orders.show', [
            'order' => $this->order,
            'sort' => 'quantity',
        ]))->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_sort_carts_by_quantity_ascending()
    {
        $user = User::factory()->create();

        [$hyundai, $sdmo] = Cart::factory()
            ->count(2)
            ->for($this->order)
            ->state(new Sequence(
                ['quantity' => 1],
                ['quantity' => 2],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.orders.show', [
                'order' => $this->order,
                'sort' => 'quantity',
            ]))->assertSuccessful()
            ->assertViewIs('admin.orders.show')
            ->assertViewHas('products')
            ->assertSeeInOrder([$hyundai->product->name, $sdmo->product->name]);
    }

    /** @test */
    public function admin_can_sort_carts_by_quantity_descending()
    {
        $user = User::factory()->create();

        [$hyundai, $sdmo] = Cart::factory()
            ->count(2)
            ->for($this->order)
            ->state(new Sequence(
                ['quantity' => 1],
                ['quantity' => 2],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.orders.show', [
                'order' => $this->order,
                'sort' => '-quantity',
            ]))->assertSuccessful()
            ->assertViewIs('admin.orders.show')
            ->assertViewHas('products')
            ->assertSeeInOrder([$sdmo->product->name, $hyundai->product->name]);
    }

    /** @test */
    public function admin_can_sort_carts_by_product_name_ascending()
    {
        $user = User::factory()->create();

        [$diesel, $patrol] = Product::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Diesel'],
                ['name' => 'Patrol'],
            ))->create();

        [$hyundai, $sdmo] = Cart::factory()
            ->count(2)
            ->for($this->order)
            ->state(new Sequence(
                ['product_id' => $diesel],
                ['product_id' => $patrol],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.orders.show', [
                'order' => $this->order,
                'sort' => 'name',
            ]))->assertSuccessful()
            ->assertViewIs('admin.orders.show')
            ->assertViewHas('products')
            ->assertSeeInOrder([$hyundai->product->name, $sdmo->product->name]);
    }

    /** @test */
    public function admin_can_sort_carts_by_product_name_descending()
    {
        $user = User::factory()->create();

        [$diesel, $patrol] = Product::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Diesel'],
                ['name' => 'Patrol'],
            ))->create();

        [$hyundai, $sdmo] = Cart::factory()
            ->count(2)
            ->for($this->order)
            ->state(new Sequence(
                ['product_id' => $diesel],
                ['product_id' => $patrol],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.orders.show', [
                'order' => $this->order,
                'sort' => '-name',
            ]))->assertSuccessful()
            ->assertViewIs('admin.orders.show')
            ->assertViewHas('products')
            ->assertSeeInOrder([$sdmo->product->name, $hyundai->product->name]);
    }

    /** @test */
    public function admin_can_sort_carts_by_total_price_ascending()
    {
        $user = User::factory()->create();

        [$diesel, $patrol] = Product::factory()
            ->count(2)
            ->state(new Sequence(
                ['price' => 1000],
                ['price' => 2000],
            ))->create();

        [$hyundai, $sdmo] = Cart::factory()
            ->count(2)
            ->for($this->order)
            ->state(new Sequence(
                ['product_id' => $diesel, 'quantity' => 1],
                ['product_id' => $patrol, 'quantity' => 1],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.orders.show', [
                'order' => $this->order,
                'sort' => 'total',
            ]))->assertSuccessful()
            ->assertViewIs('admin.orders.show')
            ->assertViewHas('products')
            ->assertSeeInOrder([$hyundai->product->name, $sdmo->product->name]);
    }

    /** @test */
    public function admin_can_sort_carts_by_total_price_descending()
    {
        $user = User::factory()->create();

        [$diesel, $patrol] = Product::factory()
            ->count(2)
            ->state(new Sequence(
                ['price' => 1000],
                ['price' => 2000],
            ))->create();

        [$hyundai, $sdmo] = Cart::factory()
            ->count(2)
            ->for($this->order)
            ->state(new Sequence(
                ['product_id' => $diesel, 'quantity' => 1],
                ['product_id' => $patrol, 'quantity' => 1],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.orders.show', [
                'order' => $this->order,
                'sort' => '-total',
            ]))->assertSuccessful()
            ->assertViewIs('admin.orders.show')
            ->assertViewHas('products')
            ->assertSeeInOrder([$sdmo->product->name, $hyundai->product->name]);
    }
}
