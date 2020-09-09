<?php

namespace Tests\Feature\Admin\Customer;

use App\Customer;
use App\Order;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchOrdersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_search_customer_orders()
    {
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->create();

        $orderOne = factory(Order::class)->create([
            'id' => 7883,
            'customer_id' => $customer->id,
            'created_at' => now()->subDay(),
        ]);

        $orderTwo = factory(Order::class)->create([
            'id' => 7882,
            'customer_id' => $customer->id,
            'created_at' => now(),
        ]);

        $orderThree = factory(Order::class)->create([
            'id' => 2992,
            'customer_id' => $customer->id,
        ]);

        $this->actingAs($user)
            ->get(route('admin.customers.show', [
                'customer' => $customer,
                'search' => ['order' => 788],
            ]))->assertSuccessful()
            ->assertSeeInOrder([$orderTwo->id, $orderOne->id])
            ->assertDontSee($orderThree->id);
    }
}
