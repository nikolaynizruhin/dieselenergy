<?php

namespace Tests\Feature\Customer;

use App\Customer;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchCustomersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_customers()
    {
        factory(Customer::class)->create(['name' => 'John Doe']);

        $this->get(route('customers.index', ['search' => 'john']))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_search_customers()
    {
        $user = factory(User::class)->create();

        $john = factory(Customer::class)->create(['name' => 'John Doe']);
        $jane = factory(Customer::class)->create(['name' => 'Jane Doe']);

        $this->actingAs($user)
            ->get(route('customers.index', ['search' => $jane->name]))
            ->assertSee($jane->email)
            ->assertDontSee($john->email);
    }
}