<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchCustomersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_customers()
    {
        Customer::factory()->create(['name' => 'John Doe']);

        $this->get(route('admin.customers.index', ['search' => 'john']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_customers()
    {
        $user = User::factory()->create();

        $john = Customer::factory()->create(['name' => 'John Doe', 'created_at' => now()->subDay()]);
        $jane = Customer::factory()->create(['name' => 'Jane Doe', 'created_at' => now()]);
        $tom = Customer::factory()->create(['name' => 'Tom Jo']);

        $this->actingAs($user)
            ->get(route('admin.customers.index', ['search' => 'Doe']))
            ->assertSeeInOrder([$jane->email, $john->email])
            ->assertDontSee($tom->email);
    }
}
