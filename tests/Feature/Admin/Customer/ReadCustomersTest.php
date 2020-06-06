<?php

namespace Tests\Feature\Admin\Customer;

use App\Customer;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadCustomersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_customers()
    {
        $this->get(route('admin.customers.index'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_customers()
    {
        $user = factory(User::class)->create();

        [$john, $jane] = factory(Customer::class, 2)->create();

        $this->actingAs($user)
            ->get(route('admin.customers.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.customers.index')
            ->assertViewHas('customers')
            ->assertSee($john->email)
            ->assertSee($jane->email);
    }
}
