<?php

use App\Enums\OrderStatus;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Sequence;

beforeEach(function () {
    $this->customer = Customer::factory()->create();
});

test('user can sort customer orders by id ascending', function () {
    [$orderOne, $orderTwo] = Order::factory()
        ->count(2)
        ->state(new Sequence(
            ['id' => 78831],
            ['id' => 78822],
        ))->create(['customer_id' => $this->customer->id]);

    $this->login()
        ->get(route('admin.customers.show', [
            'customer' => $this->customer,
            'sort' => ['order' => 'id'],
        ]))->assertSuccessful()
        ->assertSeeInOrder([$orderTwo->id, $orderOne->id]);
});

test('user can sort customer orders by id descending', function () {
    [$orderOne, $orderTwo] = Order::factory()
        ->count(2)
        ->state(new Sequence(
            ['id' => 78831],
            ['id' => 78822],
        ))->create(['customer_id' => $this->customer->id]);

    $this->login()
        ->get(route('admin.customers.show', [
            'customer' => $this->customer,
            'sort' => ['order' => '-id'],
        ]))->assertSuccessful()
        ->assertSeeInOrder([$orderOne->id, $orderTwo->id]);
});

test('user can sort customer orders by status ascending', function () {
    [$orderOne, $orderTwo] = Order::factory()
        ->count(2)
        ->state(new Sequence(
            ['status' => OrderStatus::New],
            ['status' => OrderStatus::Pending],
        ))->create(['customer_id' => $this->customer->id]);

    $this->login()
        ->get(route('admin.customers.show', [
            'customer' => $this->customer,
            'sort' => ['order' => 'status'],
        ]))->assertSuccessful()
        ->assertSeeInOrder([$orderTwo->status->value, $orderOne->status->value]);
});

test('user can sort customer orders by status descending', function () {
    [$orderOne, $orderTwo] = Order::factory()
        ->count(2)
        ->state(new Sequence(
            ['status' => OrderStatus::New],
            ['status' => OrderStatus::Pending],
        ))->create(['customer_id' => $this->customer->id]);

    $this->login()
        ->get(route('admin.customers.show', [
            'customer' => $this->customer,
            'sort' => ['order' => '-status'],
        ]))->assertSuccessful()
        ->assertSeeInOrder([$orderOne->status->value, $orderTwo->status->value]);
});

test('user can sort customer orders by date ascending', function () {
    [$orderOne, $orderTwo] = Order::factory()
        ->count(2)
        ->state(new Sequence(
            ['created_at' => now()],
            ['created_at' => now()->subDay()],
        ))->create(['customer_id' => $this->customer->id]);

    $this->login()
        ->get(route('admin.customers.show', [
            'customer' => $this->customer,
            'sort' => ['order' => 'created_at'],
        ]))->assertSuccessful()
        ->assertSeeInOrder([$orderTwo->id, $orderOne->id]);
});

test('user can sort customer orders by date descending', function () {
    [$orderOne, $orderTwo] = Order::factory()
        ->count(2)
        ->state(new Sequence(
            ['created_at' => now()],
            ['created_at' => now()->subDay()],
        ))->create(['customer_id' => $this->customer->id]);

    $this->login()
        ->get(route('admin.customers.show', [
            'customer' => $this->customer,
            'sort' => ['order' => '-created_at'],
        ]))->assertSuccessful()
        ->assertSeeInOrder([$orderOne->id, $orderTwo->id]);
});

test('user can sort customer orders by total ascending', function () {
    [$orderOne, $orderTwo] = Order::factory()
        ->count(2)
        ->state(new Sequence(
            ['total' => 200],
            ['total' => 100],
        ))->create(['customer_id' => $this->customer->id]);

    $this->login()
        ->get(route('admin.customers.show', [
            'customer' => $this->customer,
            'sort' => ['order' => 'total'],
        ]))->assertSuccessful()
        ->assertSeeInOrder([$orderTwo->id, $orderOne->id]);
});

test('user can sort customer orders by total descending', function () {
    [$orderOne, $orderTwo] = Order::factory()
        ->count(2)
        ->state(new Sequence(
            ['total' => 200],
            ['total' => 100],
        ))->create(['customer_id' => $this->customer->id]);

    $this->login()
        ->get(route('admin.customers.show', [
            'customer' => $this->customer,
            'sort' => ['order' => '-total'],
        ]))->assertSuccessful()
        ->assertSeeInOrder([$orderOne->id, $orderTwo->id]);
});
