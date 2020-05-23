<?php

namespace Tests\Feature\Customer;

use App\Customer;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadCustomersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_customers()
    {
        $this->get(route('customers.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_read_customers()
    {
        $user = factory(User::class)->create();

        [$john, $jane] = factory(Customer::class, 2)->create();

        $this->actingAs($user)
            ->get(route('customers.index'))
            ->assertSuccessful()
            ->assertViewIs('customers.index')
            ->assertViewHas('customers')
            ->assertSee($john->email)
            ->assertSee($jane->email);
    }
}
