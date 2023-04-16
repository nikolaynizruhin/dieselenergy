<?php

use App\Models\Customer;

beforeEach(function () {
    $this->customer = Customer::factory()->create();
});

test('guest cant delete customer', function () {
    $this->delete(route('admin.customers.destroy', $this->customer))
        ->assertRedirect(route('admin.login'));
});

test('user can delete customer', function () {
    $this->login()
        ->from(route('admin.customers.index'))
        ->delete(route('admin.customers.destroy', $this->customer))
        ->assertRedirect(route('admin.customers.index'))
        ->assertSessionHas('status', trans('customer.deleted'));

    $this->assertModelMissing($this->customer);
});
