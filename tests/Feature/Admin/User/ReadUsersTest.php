<?php

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant read users', function () {
    $this->get(route('admin.users.index'))
        ->assertRedirect(route('admin.login'));
});

test('user can read users', function () {
    [$john, $jane] = User::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'John Doe'],
            ['name' => 'Jane Doe'],
        ))->create();

    $this->login()
        ->get(route('admin.users.index'))
        ->assertSuccessful()
        ->assertViewIs('admin.users.index')
        ->assertViewHas('users')
        ->assertSeeInOrder([$jane->name, $john->name]);
});
