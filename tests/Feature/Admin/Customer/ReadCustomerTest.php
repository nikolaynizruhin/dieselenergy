<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadCustomerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_customer()
    {
        $customer = Customer::factory()->create();

        $this->get(route('admin.customers.show', $customer))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_customer()
    {

        $customer = Customer::factory()->create();

        $this->login()
            ->get(route('admin.customers.show', $customer))
            ->assertSuccessful()
            ->assertViewIs('admin.customers.show')
            ->assertViewHas('customer')
            ->assertSee($customer->name)
            ->assertSee($customer->email);
    }
}
