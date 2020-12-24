<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortOrdersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Order one.
     *
     * @var \App\Models\Order
     */
    private $orderOne;

    /**
     * Order two.
     *
     * @var \App\Models\Contact
     */
    private $orderTwo;

    /**
     * Customer.
     *
     * @var \App\Models\Customer
     */
    private $customer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = Customer::factory()->create();

        [$this->orderOne, $this->orderTwo] = Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['id' => 78831],
                ['id' => 78822],
            ))->create(['customer_id' => $this->customer->id]);
    }

    /** @test */
    public function user_can_sort_customer_orders_ascending()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.customers.show', [
                'customer' => $this->customer,
                'sort' => ['order' => 'id'],
            ]))->assertSuccessful()
            ->assertSeeInOrder([$this->orderTwo->id, $this->orderOne->id]);
    }

    /** @test */
    public function user_can_sort_customer_orders_descending()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.customers.show', [
                'customer' => $this->customer,
                'sort' => ['order' => '-id'],
            ]))->assertSuccessful()
            ->assertSeeInOrder([$this->orderOne->id, $this->orderTwo->id]);
    }
}
