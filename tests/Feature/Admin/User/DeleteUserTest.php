<?php

use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('guest cant delete user', function () {
    $this->delete(route('admin.users.destroy', $this->user))
        ->assertRedirect(route('admin.login'));
});

test('user can delete user', function () {
    $this->login()
        ->fromRoute('admin.users.index')
        ->delete(route('admin.users.destroy', $this->user))
        ->assertRedirect(route('admin.users.index'))
        ->assertSessionHas('status', trans('user.deleted'));

    $this->assertModelMissing($this->user);
});
