<?php

use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant sort contacts', function () {
    $this->get(route('admin.contacts.index', ['sort' => 'created_at']))
        ->assertRedirect(route('admin.login'));
});

test('admin can sort contacts by date ascending', function () {
    [$adam, $tom] = Contact::factory()
        ->count(2)
        ->state(new Sequence(
            ['created_at' => now()],
            ['created_at' => now()->subDay()],
        ))->create();

    $this->login()
        ->get(route('admin.contacts.index', ['sort' => 'created_at']))
        ->assertSuccessful()
        ->assertViewIs('admin.contacts.index')
        ->assertViewHas('contacts')
        ->assertSeeInOrder([$tom->message, $adam->message]);
});

test('admin can sort contacts by date descending', function () {
    [$adam, $tom] = Contact::factory()
        ->count(2)
        ->state(new Sequence(
            ['created_at' => now()],
            ['created_at' => now()->subDay()],
        ))->create();

    $this->login()
        ->get(route('admin.contacts.index', ['sort' => '-created_at']))
        ->assertSuccessful()
        ->assertViewIs('admin.contacts.index')
        ->assertViewHas('contacts')
        ->assertSeeInOrder([$adam->message, $tom->message]);
});

test('admin can sort contacts by message ascending', function () {
    [$adam, $tom] = Contact::factory()
        ->count(2)
        ->state(new Sequence(
            ['message' => 'hey'],
            ['message' => 'hello'],
        ))->create();

    $this->login()
        ->get(route('admin.contacts.index', ['sort' => 'message']))
        ->assertSuccessful()
        ->assertViewIs('admin.contacts.index')
        ->assertViewHas('contacts')
        ->assertSeeInOrder([$tom->message, $adam->message]);
});

test('admin can sort contacts by message descending', function () {
    [$adam, $tom] = Contact::factory()
        ->count(2)
        ->state(new Sequence(
            ['message' => 'hey'],
            ['message' => 'hello'],
        ))->create();

    $this->login()
        ->get(route('admin.contacts.index', ['sort' => '-message']))
        ->assertSuccessful()
        ->assertViewIs('admin.contacts.index')
        ->assertViewHas('contacts')
        ->assertSeeInOrder([$adam->message, $tom->message]);
});

test('admin can sort contacts by customer ascending', function () {
    [$adam, $tom] = Customer::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'Adam'],
            ['name' => 'Tom'],
        ))->create();

    Contact::factory()
        ->count(2)
        ->state(new Sequence(
            ['customer_id' => $adam],
            ['customer_id' => $tom],
        ))->create();

    $this->login()
        ->get(route('admin.contacts.index', ['sort' => 'customers.name']))
        ->assertSuccessful()
        ->assertViewIs('admin.contacts.index')
        ->assertViewHas('contacts')
        ->assertSeeInOrder([$adam->name, $tom->name]);
});

test('admin can sort contacts by customer descending', function () {
    [$adam, $tom] = Customer::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'Adam'],
            ['name' => 'Tom'],
        ))->create();

    Contact::factory()
        ->count(2)
        ->state(new Sequence(
            ['customer_id' => $adam],
            ['customer_id' => $tom],
        ))->create();

    $this->login()
        ->get(route('admin.contacts.index', ['sort' => '-customers.name']))
        ->assertSuccessful()
        ->assertViewIs('admin.contacts.index')
        ->assertViewHas('contacts')
        ->assertSeeInOrder([$tom->name, $adam->name]);
});
