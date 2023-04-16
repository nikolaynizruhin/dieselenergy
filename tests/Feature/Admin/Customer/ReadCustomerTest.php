<?php

use App\Models\Customer;

test('guest cant read customer', function () {
    $customer = Customer::factory()->create();

    $this->get(route('admin.customers.show', $customer))
        ->assertRedirect(route('admin.login'));
});

test('user can read customer', function () {
    $customer = Customer::factory()->create();

    $this->login()
        ->get(route('admin.customers.show', $customer))
        ->assertSuccessful()
        ->assertViewIs('admin.customers.show')
        ->assertViewHas('customer')
        ->assertSee($customer->name)
        ->assertSee($customer->email);
});
