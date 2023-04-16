<?php

namespace Tests\Feature\Admin\Order;

test('guest cant visit create order page', function () {
    $this->get(route('admin.orders.create'))
        ->assertRedirect(route('admin.login'));
});

test('user can visit create order page', function () {
    $this->login()
        ->get(route('admin.orders.create'))
        ->assertViewIs('admin.orders.create')
        ->assertViewHas(['products', 'customers', 'statuses']);
});

test('guest cant create product', function () {
    $this->post(route('admin.orders.store'), validFields())
        ->assertRedirect(route('admin.login'));
});

test('user can create order', function () {
    $this->login()
        ->post(route('admin.orders.store'), $fields = validFields(['total' => 0]))
        ->assertRedirect(route('admin.orders.index'))
        ->assertSessionHas('status', trans('order.created'));

    $this->assertDatabaseHas('orders', $fields);
});

test('user cant create order with invalid data', function (string $field, callable $data, int $count = 0) {
    $this->login()
        ->from(route('admin.orders.create'))
        ->post(route('admin.orders.store'), $data())
        ->assertRedirect(route('admin.orders.create'))
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('orders', $count);
})->with('create_order');
