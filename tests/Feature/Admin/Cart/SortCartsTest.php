<?php

namespace Tests\Feature\Admin\Cart;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortCartsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Euro currency.
     *
     * @var \App\Models\Cart
     */
    private $hyundai;

    /**
     * Dollar currency.
     *
     * @var \App\Models\Cart
     */
    private $sdmo;

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

        [$this->hyundai, $this->sdmo] = Cart::factory()
            ->count(2)
            ->for($this->order)
            ->state(new Sequence(
                ['quantity' => 1],
                ['quantity' => 2],
            ))->create();
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
    public function admin_can_sort_carts_ascending()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.orders.show', [
                'order' => $this->order,
                'sort' => 'quantity',
            ]))->assertSuccessful()
            ->assertViewIs('admin.orders.show')
            ->assertViewHas('products')
            ->assertSeeInOrder([
                $this->hyundai->product->name,
                $this->sdmo->product->name,
            ]);
    }

    /** @test */
    public function admin_can_sort_carts_descending()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.orders.show', [
                'order' => $this->order,
                'sort' => '-quantity',
            ]))->assertSuccessful()
            ->assertViewIs('admin.orders.show')
            ->assertViewHas('products')
            ->assertSeeInOrder([
                $this->sdmo->product->name,
                $this->hyundai->product->name,
            ]);
    }
}
