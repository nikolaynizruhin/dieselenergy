<?php

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant read customers', function () {
    $this->get(route('admin.customers.index'))
        ->assertRedirect(route('admin.login'));
});

test('user can read customers', function () {
    [$jane, $john] = Customer::factory()
        ->count(2)
        ->state(new Sequence(
            ['created_at' => now()->subDay()],
            ['created_at' => now()]
        ))->create();

    $this->login()
        ->get(route('admin.customers.index'))
        ->assertSuccessful()
        ->assertViewIs('admin.customers.index')
        ->assertViewHas('customers')
        ->assertSeeInOrder([$john->email, $jane->email]);
});
