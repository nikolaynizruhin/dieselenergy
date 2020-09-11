<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Customer;
use App\Models\User;
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
        $user = User::factory()->create();

        $jane = Customer::factory()->create(['created_at' => now()->subDay()]);
        $john = Customer::factory()->create(['created_at' => now()]);

        $this->actingAs($user)
            ->get(route('admin.customers.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.customers.index')
            ->assertViewHas('customers')
            ->assertSeeInOrder([$john->email, $jane->email]);
    }
}
