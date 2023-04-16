<?php

use App\Enums\OrderStatus;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant sort orders', function () {
    $this->get(route('admin.orders.index', ['sort' => 'id']))
        ->assertRedirect(route('admin.login'));
});

test('admin can sort orders by id ascending', function () {
    [$adam, $tom] = Order::factory()
        ->count(2)
        ->state(new Sequence(
            ['id' => 788365],
            ['id' => 987445],
        ))->create();

    $this->login()
        ->get(route('admin.orders.index', ['sort' => 'id']))
        ->assertSuccessful()
        ->assertViewIs('admin.orders.index')
        ->assertViewHas('orders')
        ->assertSeeInOrder([$adam->id, $tom->id]);
});

test('admin can sort orders by id descending', function () {
    [$adam, $tom] = Order::factory()
        ->count(2)
        ->state(new Sequence(
            ['id' => 788365],
            ['id' => 987445],
        ))->create();

    $this->login()
        ->get(route('admin.orders.index', ['sort' => '-id']))
        ->assertSuccessful()
        ->assertViewIs('admin.orders.index')
        ->assertViewHas('orders')
        ->assertSeeInOrder([$tom->id, $adam->id]);
});

test('admin can sort orders by status ascending', function () {
    [$adam, $tom] = Order::factory()
        ->count(2)
        ->state(new Sequence(
            ['status' => OrderStatus::Pending],
            ['status' => OrderStatus::New],
        ))->create();

    $this->login()
        ->get(route('admin.orders.index', ['sort' => 'status']))
        ->assertSuccessful()
        ->assertViewIs('admin.orders.index')
        ->assertViewHas('orders')
        ->assertSeeInOrder([$adam->status->value, $tom->status->value]);
});

test('admin can sort orders by status descending', function () {
    [$adam, $tom] = Order::factory()
        ->count(2)
        ->state(new Sequence(
            ['status' => OrderStatus::Pending],
            ['status' => OrderStatus::New],
        ))->create();

    $this->login()
        ->get(route('admin.orders.index', ['sort' => '-status']))
        ->assertSuccessful()
        ->assertViewIs('admin.orders.index')
        ->assertViewHas('orders')
        ->assertSeeInOrder([$tom->status->value, $adam->status->value]);
});

test('admin can sort orders by created date ascending', function () {
    [$adam, $tom] = Order::factory()
        ->count(2)
        ->state(new Sequence(
            ['created_at' => now()],
            ['created_at' => now()->subDay()],
        ))->create();

    $this->login()
        ->get(route('admin.orders.index', ['sort' => 'created_at']))
        ->assertSuccessful()
        ->assertViewIs('admin.orders.index')
        ->assertViewHas('orders')
        ->assertSeeInOrder([$adam->id, $tom->id]);
});

test('admin can sort orders by created date descending', function () {
    [$adam, $tom] = Order::factory()
        ->count(2)
        ->state(new Sequence(
            ['created_at' => now()],
            ['created_at' => now()->subDay()],
        ))->create();

    $this->login()
        ->get(route('admin.orders.index', ['sort' => '-created_at']))
        ->assertSuccessful()
        ->assertViewIs('admin.orders.index')
        ->assertViewHas('orders')
        ->assertSeeInOrder([$tom->id, $adam->id]);
});

test('admin can sort orders by total ascending', function () {
    [$adam, $tom] = Order::factory()
        ->count(2)
        ->state(new Sequence(
            ['total' => 100],
            ['total' => 200],
        ))->create();

    $this->login()
        ->get(route('admin.orders.index', ['sort' => 'total']))
        ->assertSuccessful()
        ->assertViewIs('admin.orders.index')
        ->assertViewHas('orders')
        ->assertSeeInOrder([$adam->id, $tom->id]);
});

test('admin can sort orders by total descending', function () {
    [$adam, $tom] = Order::factory()
        ->count(2)
        ->state(new Sequence(
            ['total' => 100],
            ['total' => 200],
        ))->create();

    $this->login()
        ->get(route('admin.orders.index', ['sort' => '-total']))
        ->assertSuccessful()
        ->assertViewIs('admin.orders.index')
        ->assertViewHas('orders')
        ->assertSeeInOrder([$tom->id, $adam->id]);
});

test('admin can sort orders by client ascending', function () {
    [$adam, $tom] = Customer::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'Adam'],
            ['name' => 'Tom'],
        ))->create();

    Order::factory()
        ->count(2)
        ->state(new Sequence(
            ['id' => 788365, 'customer_id' => $adam],
            ['id' => 987445, 'customer_id' => $tom],
        ))->create();

    $this->login()
        ->get(route('admin.orders.index', ['sort' => 'customers.name']))
        ->assertSuccessful()
        ->assertViewIs('admin.orders.index')
        ->assertViewHas('orders')
        ->assertSeeInOrder([$adam->name, $tom->name]);
});

test('admin can sort orders by client descending', function () {
    [$adam, $tom] = Customer::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'Adam'],
            ['name' => 'Tom'],
        ))->create();

    Order::factory()
        ->count(2)
        ->state(new Sequence(
            ['id' => 788365, 'customer_id' => $adam],
            ['id' => 987445, 'customer_id' => $tom],
        ))->create();

    $this->login()
        ->get(route('admin.orders.index', ['sort' => '-customers.name']))
        ->assertSuccessful()
        ->assertViewIs('admin.orders.index')
        ->assertViewHas('orders')
        ->assertSeeInOrder([$tom->name, $adam->name]);
});
