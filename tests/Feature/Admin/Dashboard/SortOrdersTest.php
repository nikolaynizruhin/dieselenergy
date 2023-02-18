<?php

namespace Tests\Feature\Admin\Dashboard;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class SortOrdersTest extends TestCase
{
    /**
     * Adam's order.
     */
    private Order $adam;

    /**
     * Tom's order.
     */
    private Order $tom;

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
    public function guest_cant_sort_orders(): void
    {
        $this->get(route('admin.dashboard', ['sort' => 'id']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_sort_orders_ascending(): void
    {
        $this->login()
            ->get(route('admin.dashboard', ['sort' => 'id']))
            ->assertSuccessful()
            ->assertViewIs('admin.dashboard')
            ->assertViewHas('orders')
            ->assertSeeInOrder([$this->adam->id, $this->tom->id]);
    }

    /** @test */
    public function admin_can_sort_orders_descending(): void
    {
        $this->login()
            ->get(route('admin.dashboard', ['sort' => '-id']))
            ->assertSuccessful()
            ->assertViewIs('admin.dashboard')
            ->assertViewHas('orders')
            ->assertSeeInOrder([$this->tom->id, $this->adam->id]);
    }
}
