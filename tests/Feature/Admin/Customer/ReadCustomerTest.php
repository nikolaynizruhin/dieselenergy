<?php

namespace Tests\Feature\Admin\Customer;

use App\Customer;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadCustomerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_customer()
    {
        $customer = factory(Customer::class)->create();

        $this->get(route('admin.customers.show', $customer))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_customer()
    {
        $user = factory(User::class)->create();
        $customer = factory(Customer::class)->create();

        $this->actingAs($user)
            ->get(route('admin.customers.show', $customer))
            ->assertSuccessful()
            ->assertViewIs('admin.customers.show')
            ->assertViewHas('customer')
            ->assertSee($customer->name)
            ->assertSee($customer->email);
    }
}
