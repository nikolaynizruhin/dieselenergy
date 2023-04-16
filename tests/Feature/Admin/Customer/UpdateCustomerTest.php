<?php

namespace Tests\Feature\Admin\Customer;

use App\Models\Customer;

beforeEach(function () {
    $this->customer = Customer::factory()->create();
});

test('guest cant visit update customer page', function () {
    $this->get(route('admin.customers.edit', $this->customer))
        ->assertRedirect(route('admin.login'));
});

test('user can visit update customer page', function () {
    $this->login()
        ->get(route('admin.customers.edit', $this->customer))
        ->assertViewIs('admin.customers.edit');
});

test('guest cant update customer', function () {
    $this->put(route('admin.customers.update', $this->customer), validFields())
        ->assertRedirect(route('admin.login'));
});

test('user can update customer', function () {
    $this->login()
        ->put(route('admin.customers.update', $this->customer), $fields = validFields())
        ->assertRedirect(route('admin.customers.index'))
        ->assertSessionHas('status', trans('customer.updated'));

    $this->assertDatabaseHas('customers', $fields);
});

test('user cant update customer with invalid data', function (string $field, callable $data, int $count = 1) {
    $this->login()
        ->from(route('admin.customers.edit', $this->customer))
        ->put(route('admin.customers.update', $this->customer), $data())
        ->assertRedirect(route('admin.customers.edit', $this->customer))
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('customers', $count);
})->with('update_customer');
