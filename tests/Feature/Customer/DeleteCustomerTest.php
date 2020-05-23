<?php

namespace Tests\Feature\Customer;

use App\Customer;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCustomerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_delete_customer()
    {
        $customer = factory(Customer::class)->create();

        $this->delete(route('customers.destroy', $customer))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_delete_customer()
    {
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->create();

        $this->actingAs($user)
            ->from(route('customers.index'))
            ->delete(route('customers.destroy', $customer))
            ->assertRedirect(route('customers.index'))
            ->assertSessionHas('status', 'Customer was deleted successfully!');

        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }
}
