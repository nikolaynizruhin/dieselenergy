<?php

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant search users', function () {
    User::factory()->create(['name' => 'John Doe']);

    $this->get(route('admin.users.index', ['search' => 'john']))
        ->assertRedirect(route('admin.login'));
});

test('user can search users', function () {
    [$john, $jane, $tom] = User::factory()
        ->count(3)
        ->state(new Sequence(
            ['name' => 'John Doe'],
            ['name' => 'Jane Doe'],
            ['name' => 'Tom Jo'],
        ))->create();

    $this->login()
        ->get(route('admin.users.index', ['search' => 'Doe']))
        ->assertSeeInOrder([$jane->email, $john->email])
        ->assertDontSee($tom->email);
});
