<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchOrdersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_search_customer_orders()
    {
        $customer = Customer::factory()->create();

        [$orderOne, $orderTwo, $orderThree] = Order::factory()
            ->count(3)
            ->state(new Sequence(
                ['id' => 7883, 'created_at' => now()->subDay()],
                ['id' => 7882],
                ['id' => 2992],
            ))->create(['customer_id' => $customer->id]);

        $this->login()
            ->get(route('admin.customers.show', [
                'customer' => $customer,
                'search' => ['order' => 788],
            ]))->assertSuccessful()
            ->assertSeeInOrder([$orderTwo->id, $orderOne->id])
            ->assertDontSee($orderThree->id);
    }
}
