<?php

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant sort users', function () {
    $this->get(route('admin.users.index', ['sort' => 'name']))
        ->assertRedirect(route('admin.login'));
});

test('admin can sort users by name ascending', function () {
    [$adam, $ben] = User::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'Adam'],
            ['name' => 'Ben'],
        ))->create();

    $this->login()
        ->get(route('admin.users.index', ['sort' => 'name']))
        ->assertSuccessful()
        ->assertViewIs('admin.users.index')
        ->assertViewHas('users')
        ->assertSeeInOrder([$adam->name, $ben->name]);
});

test('admin can sort users by name descending', function () {
    [$adam, $ben] = User::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'Adam'],
            ['name' => 'Ben'],
        ))->create();

    $this->login()
        ->get(route('admin.users.index', ['sort' => '-name']))
        ->assertSuccessful()
        ->assertViewIs('admin.users.index')
        ->assertViewHas('users')
        ->assertSeeInOrder([$ben->name, $adam->name]);
});

test('admin can sort users by email ascending', function () {
    [$adam, $ben] = User::factory()
        ->count(2)
        ->state(new Sequence(
            ['email' => 'adam@example.com'],
            ['email' => 'ben@example.com'],
        ))->create();

    $this->login()
        ->get(route('admin.users.index', ['sort' => 'email']))
        ->assertSuccessful()
        ->assertViewIs('admin.users.index')
        ->assertViewHas('users')
        ->assertSeeInOrder([$adam->email, $ben->email]);
});

test('admin can sort users by email descending', function () {
    [$adam, $ben] = User::factory()
        ->count(2)
        ->state(new Sequence(
            ['email' => 'adam@example.com'],
            ['email' => 'ben@example.com'],
        ))->create();

    $this->login()
        ->get(route('admin.users.index', ['sort' => '-email']))
        ->assertSuccessful()
        ->assertViewIs('admin.users.index')
        ->assertViewHas('users')
        ->assertSeeInOrder([$ben->email, $adam->email]);
});
