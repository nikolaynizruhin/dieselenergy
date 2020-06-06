<?php

namespace Tests\Feature\Admin\Customer;

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

        $this->get(route('admin.customers.index', ['search' => 'john']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_customers()
    {
        $user = factory(User::class)->create();

        $john = factory(Customer::class)->create(['name' => 'John Doe', 'created_at' => now()->subDay()]);
        $jane = factory(Customer::class)->create(['name' => 'Jane Doe', 'created_at' => now()]);
        $tom = factory(Customer::class)->create(['name' => 'Tom Jo']);

        $this->actingAs($user)
            ->get(route('admin.customers.index', ['search' => 'Doe']))
            ->assertSeeInOrder([$jane->email, $john->email])
            ->assertDontSee($tom->email);
    }
}
