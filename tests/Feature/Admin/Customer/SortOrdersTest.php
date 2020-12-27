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
     * Customer.
     *
     * @var \App\Models\Customer
     */
    private $customer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = Customer::factory()->create();
    }

    /** @test */
    public function user_can_sort_customer_orders_by_id_ascending()
    {
        $user = User::factory()->create();

        [$orderOne, $orderTwo] = Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['id' => 78831],
                ['id' => 78822],
            ))->create(['customer_id' => $this->customer->id]);

        $this->actingAs($user)
            ->get(route('admin.customers.show', [
                'customer' => $this->customer,
                'sort' => ['order' => 'id'],
            ]))->assertSuccessful()
            ->assertSeeInOrder([$orderTwo->id, $orderOne->id]);
    }

    /** @test */
    public function user_can_sort_customer_orders_by_id_descending()
    {
        $user = User::factory()->create();

        [$orderOne, $orderTwo] = Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['id' => 78831],
                ['id' => 78822],
            ))->create(['customer_id' => $this->customer->id]);

        $this->actingAs($user)
            ->get(route('admin.customers.show', [
                'customer' => $this->customer,
                'sort' => ['order' => '-id'],
            ]))->assertSuccessful()
            ->assertSeeInOrder([$orderOne->id, $orderTwo->id]);
    }
}
