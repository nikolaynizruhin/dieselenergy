<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Customer;
use Tests\TestCase;

class DeleteCustomerTest extends TestCase
{
    /**
     * Customer.
     */
    private Customer $customer;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = Customer::factory()->create();
    }

    /** @test */
    public function guest_cant_delete_customer(): void
    {
        $this->delete(route('admin.customers.destroy', $this->customer))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_customer(): void
    {
        $this->login()
            ->from(route('admin.customers.index'))
            ->delete(route('admin.customers.destroy', $this->customer))
            ->assertRedirect(route('admin.customers.index'))
            ->assertSessionHas('status', trans('customer.deleted'));

        $this->assertModelMissing($this->customer);
    }
}
