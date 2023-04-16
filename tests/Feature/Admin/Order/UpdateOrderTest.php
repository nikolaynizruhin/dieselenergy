<?php

namespace Tests\Feature\Admin\Order;

use App\Models\Order;

beforeEach(function () {
    $this->order = Order::factory()->create();
});

test('guest cant visit update order page', function () {
    $this->get(route('admin.orders.edit', $this->order))
        ->assertRedirect(route('admin.login'));
});

test('user can visit update order page', function () {
    $this->login()
        ->get(route('admin.orders.edit', $this->order))
        ->assertViewIs('admin.orders.edit')
        ->assertViewHas('order', $this->order)
        ->assertViewHas(['customers', 'statuses', 'products']);
});

test('guest cant update order', function () {
    $this->put(route('admin.orders.update', $this->order), validFields())
        ->assertRedirect(route('admin.login'));
});

test('user can update order', function () {
    $this->login()
        ->put(route('admin.orders.update', $this->order), $fields = validFields())
        ->assertRedirect(route('admin.orders.index'))
        ->assertSessionHas('status', trans('order.updated'));

    $this->assertDatabaseHas('orders', array_merge($fields, [
        'total' => $fields['total'] * 100,
    ]));
});

test('user cant update order with invalid data', function (string $field, callable $data) {
    $this->login()
        ->from(route('admin.orders.edit', $this->order))
        ->put(route('admin.orders.update', $this->order), $data())
        ->assertRedirect(route('admin.orders.edit', $this->order))
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('orders', 1);
})->with('update_order');
