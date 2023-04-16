<?php

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant sort customers', function () {
    $this->get(route('admin.customers.index', ['sort' => 'name']))
        ->assertRedirect(route('admin.login'));
});

test('admin can sort customers by name ascending', function () {
    [$adam, $tom] = Customer::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'Adam'],
            ['name' => 'Tom'],
        ))->create();

    $this->login()
        ->get(route('admin.customers.index', ['sort' => 'name']))
        ->assertSuccessful()
        ->assertViewIs('admin.customers.index')
        ->assertViewHas('customers')
        ->assertSeeInOrder([$adam->name, $tom->name]);
});

test('admin can sort customers by name descending', function () {
    [$adam, $tom] = Customer::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'Adam'],
            ['name' => 'Tom'],
        ))->create();

    $this->login()
        ->get(route('admin.customers.index', ['sort' => '-name']))
        ->assertSuccessful()
        ->assertViewIs('admin.customers.index')
        ->assertViewHas('customers')
        ->assertSeeInOrder([$tom->name, $adam->name]);
});

test('admin can sort customers by email ascending', function () {
    [$adam, $tom] = Customer::factory()
        ->count(2)
        ->state(new Sequence(
            ['email' => 'adam@example.com'],
            ['email' => 'tom@example.com'],
        ))->create();

    $this->login()
        ->get(route('admin.customers.index', ['sort' => 'email']))
        ->assertSuccessful()
        ->assertViewIs('admin.customers.index')
        ->assertViewHas('customers')
        ->assertSeeInOrder([$adam->email, $tom->email]);
});

test('admin can sort customers by email descending', function () {
    [$adam, $tom] = Customer::factory()
        ->count(2)
        ->state(new Sequence(
            ['email' => 'adam@example.com'],
            ['email' => 'tom@example.com'],
        ))->create();

    $this->login()
        ->get(route('admin.customers.index', ['sort' => '-email']))
        ->assertSuccessful()
        ->assertViewIs('admin.customers.index')
        ->assertViewHas('customers')
        ->assertSeeInOrder([$tom->email, $adam->email]);
});

test('admin can sort customers by phone ascending', function () {
    [$adam, $tom] = Customer::factory()
        ->count(2)
        ->state(new Sequence(
            ['phone' => '+380631234567'],
            ['phone' => '+380632234567'],
        ))->create();

    $this->login()
        ->get(route('admin.customers.index', ['sort' => 'phone']))
        ->assertSuccessful()
        ->assertViewIs('admin.customers.index')
        ->assertViewHas('customers')
        ->assertSeeInOrder([$adam->phone, $tom->phone]);
});

test('admin can sort customers by phone descending', function () {
    [$adam, $tom] = Customer::factory()
        ->count(2)
        ->state(new Sequence(
            ['phone' => '+380631234567'],
            ['phone' => '+380632234567'],
        ))->create();

    $this->login()
        ->get(route('admin.customers.index', ['sort' => '-phone']))
        ->assertSuccessful()
        ->assertViewIs('admin.customers.index')
        ->assertViewHas('customers')
        ->assertSeeInOrder([$tom->phone, $adam->phone]);
});
