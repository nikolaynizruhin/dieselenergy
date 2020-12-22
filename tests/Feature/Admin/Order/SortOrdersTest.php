<?php

namespace Tests\Feature\Admin\Order;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortOrdersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Adam's order.
     *
     * @var \App\Models\Order
     */
    private $adam;

    /**
     * Tom's order.
     *
     * @var \App\Models\Order
     */
    private $tom;

    protected function setUp(): void
    {
        parent::setUp();

        [$this->adam, $this->tom] = Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['id' => 788365],
                ['id' => 987445],
            ))->create();
    }

    /** @test */
    public function guest_cant_sort_orders()
    {
        $this->get(route('admin.orders.index', ['sort' => 'id']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_sort_orders_ascending()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.orders.index', ['sort' => 'id']))
            ->assertSuccessful()
            ->assertViewIs('admin.orders.index')
            ->assertViewHas('orders')
            ->assertSeeInOrder([$this->adam->id, $this->tom->id]);
    }

    /** @test */
    public function admin_can_sort_orders_descending()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.orders.index', ['sort' => '-id']))
            ->assertSuccessful()
            ->assertViewIs('admin.orders.index')
            ->assertViewHas('orders')
            ->assertSeeInOrder([$this->tom->id, $this->adam->id]);
    }
}
