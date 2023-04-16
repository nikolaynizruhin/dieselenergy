<?php

namespace Tests\Feature\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('guest cant update user password', function () {
    $this->put(route('admin.users.password.update', $this->user), passwordFields())
        ->assertRedirect(route('admin.login'));

    $this->assertTrue(Hash::check('password', $this->user->fresh()->password));
});

test('user can update user password', function () {
    $this->actingAs($this->user)
        ->from(route('admin.users.password.update', $this->user))
        ->put(route('admin.users.password.update', $this->user), passwordFields())
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('status', trans('user.password.updated'));

    $this->assertTrue(Hash::check('new-password', $this->user->fresh()->password));
});

test('user cant update user with invalid password', function (string $field, callable $data) {
    $this->actingAs($this->user)
        ->from(route('admin.users.password.update', $this->user))
        ->put(route('admin.users.password.update', $this->user), $data())
        ->assertRedirect(route('admin.users.password.update', $this->user))
        ->assertSessionHasErrors($field);

    $this->assertTrue(Hash::check('password', $this->user->fresh()->password));
})->with('update_password');
