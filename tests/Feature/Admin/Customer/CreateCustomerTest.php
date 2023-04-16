<?php

namespace Tests\Feature\Admin\Customer;

test('guest cant visit create customer page', function () {
    $this->get(route('admin.customers.create'))
        ->assertRedirect(route('admin.login'));
});

test('user can visit create customer page', function () {
    $this->login()
        ->get(route('admin.customers.create'))
        ->assertViewIs('admin.customers.create');
});

test('guest cant create customer', function () {
    $this->post(route('admin.customers.store'), validFields())
        ->assertRedirect(route('admin.login'));
});

test('user can create customer', function () {
    $this->login()
        ->post(route('admin.customers.store'), $fields = validFields())
        ->assertRedirect(route('admin.customers.index'))
        ->assertSessionHas('status', trans('customer.created'));

    $this->assertDatabaseHas('customers', $fields);
});

test('user cant create customer with invalid data', function (string $field, callable $data, int $count = 0) {
    $this->login()
        ->from(route('admin.customers.create'))
        ->post(route('admin.customers.store'), $data())
        ->assertRedirect(route('admin.customers.create'))
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('customers', $count);
})->with('create_customer');
