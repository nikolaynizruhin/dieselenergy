<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Customer;
use App\Models\Order;
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
        [$orderOne, $orderTwo] = Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['id' => 78831],
                ['id' => 78822],
            ))->create(['customer_id' => $this->customer->id]);

        $this->login()
            ->get(route('admin.customers.show', [
                'customer' => $this->customer,
                'sort' => ['order' => 'id'],
            ]))->assertSuccessful()
            ->assertSeeInOrder([$orderTwo->id, $orderOne->id]);
    }

    /** @test */
    public function user_can_sort_customer_orders_by_id_descending()
    {
        [$orderOne, $orderTwo] = Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['id' => 78831],
                ['id' => 78822],
            ))->create(['customer_id' => $this->customer->id]);

        $this->login()
            ->get(route('admin.customers.show', [
                'customer' => $this->customer,
                'sort' => ['order' => '-id'],
            ]))->assertSuccessful()
            ->assertSeeInOrder([$orderOne->id, $orderTwo->id]);
    }

    /** @test */
    public function user_can_sort_customer_orders_by_status_ascending()
    {
        [$orderOne, $orderTwo] = Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['status' => Order::NEW],
                ['status' => Order::PENDING],
            ))->create(['customer_id' => $this->customer->id]);

        $this->login()
            ->get(route('admin.customers.show', [
                'customer' => $this->customer,
                'sort' => ['order' => 'status'],
            ]))->assertSuccessful()
            ->assertSeeInOrder([$orderTwo->status, $orderOne->status]);
    }

    /** @test */
    public function user_can_sort_customer_orders_by_status_descending()
    {
        [$orderOne, $orderTwo] = Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['status' => Order::NEW],
                ['status' => Order::PENDING],
            ))->create(['customer_id' => $this->customer->id]);

        $this->login()
            ->get(route('admin.customers.show', [
                'customer' => $this->customer,
                'sort' => ['order' => '-status'],
            ]))->assertSuccessful()
            ->assertSeeInOrder([$orderOne->status, $orderTwo->status]);
    }

    /** @test */
    public function user_can_sort_customer_orders_by_date_ascending()
    {
        [$orderOne, $orderTwo] = Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['created_at' => now()],
                ['created_at' => now()->subDay()],
            ))->create(['customer_id' => $this->customer->id]);

        $this->login()
            ->get(route('admin.customers.show', [
                'customer' => $this->customer,
                'sort' => ['order' => 'created_at'],
            ]))->assertSuccessful()
            ->assertSeeInOrder([$orderTwo->id, $orderOne->id]);
    }

    /** @test */
    public function user_can_sort_customer_orders_by_date_descending()
    {
        [$orderOne, $orderTwo] = Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['created_at' => now()],
                ['created_at' => now()->subDay()],
            ))->create(['customer_id' => $this->customer->id]);

        $this->login()
            ->get(route('admin.customers.show', [
                'customer' => $this->customer,
                'sort' => ['order' => '-created_at'],
            ]))->assertSuccessful()
            ->assertSeeInOrder([$orderOne->id, $orderTwo->id]);
    }

    /** @test */
    public function user_can_sort_customer_orders_by_total_ascending()
    {
        [$orderOne, $orderTwo] = Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['total' => 200],
                ['total' => 100],
            ))->create(['customer_id' => $this->customer->id]);

        $this->login()
            ->get(route('admin.customers.show', [
                'customer' => $this->customer,
                'sort' => ['order' => 'total'],
            ]))->assertSuccessful()
            ->assertSeeInOrder([$orderTwo->id, $orderOne->id]);
    }

    /** @test */
    public function user_can_sort_customer_orders_by_total_descending()
    {
        [$orderOne, $orderTwo] = Order::factory()
            ->count(2)
            ->state(new Sequence(
                ['total' => 200],
                ['total' => 100],
            ))->create(['customer_id' => $this->customer->id]);

        $this->login()
            ->get(route('admin.customers.show', [
                'customer' => $this->customer,
                'sort' => ['order' => '-total'],
            ]))->assertSuccessful()
            ->assertSeeInOrder([$orderOne->id, $orderTwo->id]);
    }
}
