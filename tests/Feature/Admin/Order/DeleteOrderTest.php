<?php

use App\Models\Order;

beforeEach(function () {
    $this->order = Order::factory()->create();
});

test('guest cant delete order', function () {
    $this->delete(route('admin.orders.destroy', $this->order))
        ->assertRedirect(route('admin.login'));
});

test('user can delete order', function () {
    $this->login()
        ->fromRoute('admin.orders.index')
        ->delete(route('admin.orders.destroy', $this->order))
        ->assertRedirect(route('admin.orders.index'))
        ->assertSessionHas('status', trans('order.deleted'));

    $this->assertModelMissing($this->order);
});
