<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCustomerTest extends TestCase
{


    /** @test */
    public function guest_cant_delete_customer()
    {
        $customer = Customer::factory()->create();

        $this->delete(route('admin.customers.destroy', $customer))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_customer()
    {
        $customer = Customer::factory()->create();

        $this->login()
            ->from(route('admin.customers.index'))
            ->delete(route('admin.customers.destroy', $customer))
            ->assertRedirect(route('admin.customers.index'))
            ->assertSessionHas('status', trans('customer.deleted'));

        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }
}
