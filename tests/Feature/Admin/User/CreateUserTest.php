<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('guest cant visit create user page', function () {
    $this->get(route('admin.users.create'))
        ->assertRedirect(route('admin.login'));
});

test('user can visit create user page', function () {
    $this->login()
        ->get(route('admin.users.create'))
        ->assertViewIs('admin.users.create');
});

test('guest cant create user', function () {
    $this->post(route('admin.users.store'), validFields())
        ->assertRedirect(route('admin.login'));
});

test('user can create user', function () {
    $this->login()
        ->post(route('admin.users.store'), $fields = validFields())
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('status', trans('user.created'));

    $user = User::firstWhere('email', $fields['email']);

    expect($fields['name'])->toEqual($user->name);
    expect($fields['email'])->toEqual($user->email);
    expect(Hash::check('new-password', $user->password))->toBeTrue();
});

test('user_cant_create_user_with_invalid_data', function (string $field, callable $data, int $count = 1) {
    $this->login()
        ->fromRoute('admin.users.create')
        ->post(route('admin.users.store'), $data())
        ->assertRedirect(route('admin.users.create'))
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('users', $count);
})->with('create_user');
