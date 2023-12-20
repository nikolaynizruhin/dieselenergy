<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('guest cant visit update user page', function () {
    $this->get(route('admin.users.edit', $this->user))
        ->assertRedirect(route('admin.login'));
});

test('user can visit update user page', function () {
    $this->actingAs($this->user)
        ->get(route('admin.users.edit', $this->user))
        ->assertViewIs('admin.users.edit')
        ->assertViewHas('user', $this->user);
});

test('guest cant update user', function () {
    $this->put(route('admin.users.update', $this->user), validFields([], false))
        ->assertRedirect(route('admin.login'));
});

test('user can update user', function () {
    $this->actingAs($this->user)
        ->put(route('admin.users.update', $this->user), $fields = validFields([], false))
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('status', trans('user.updated'));

    $this->assertDatabaseHas('users', [
        'name' => $fields['name'],
        'email' => $fields['email'],
    ]);
});

test('user cant update user with invalid data', function (string $field, callable $data, int $count = 1) {
    $this->actingAs($this->user)
        ->fromRoute('admin.users.edit', $this->user)
        ->put(route('admin.users.update', $this->user), $data())
        ->assertRedirect(route('admin.users.edit', $this->user))
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('users', $count);
})->with('update_user');
