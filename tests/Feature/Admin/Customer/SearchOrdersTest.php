<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchOrdersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_search_customer_orders()
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->create();

        $orderOne = Order::factory()->create([
            'id' => 7883,
            'customer_id' => $customer->id,
            'created_at' => now()->subDay(),
        ]);

        $orderTwo = Order::factory()->create([
            'id' => 7882,
            'customer_id' => $customer->id,
            'created_at' => now(),
        ]);

        $orderThree = Order::factory()->create([
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
