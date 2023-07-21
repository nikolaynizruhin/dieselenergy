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

    expect(Hash::check('password', $this->user->fresh()->password))->toBeTrue();
});

test('user can update user password', function () {
    $this->actingAs($this->user)
        ->from(route('admin.users.password.update', $this->user))
        ->put(route('admin.users.password.update', $this->user), passwordFields())
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('status', trans('user.password.updated'));

    expect(Hash::check('new-password', $this->user->fresh()->password))->toBeTrue();
});

test('user cant update user with invalid password', function (string $field, callable $data) {
    $this->actingAs($this->user)
        ->from(route('admin.users.password.update', $this->user))
        ->put(route('admin.users.password.update', $this->user), $data())
        ->assertRedirect(route('admin.users.password.update', $this->user))
        ->assertSessionHasErrors($field);

    expect(Hash::check('password', $this->user->fresh()->password))->toBeTrue();
})->with('update_password');
