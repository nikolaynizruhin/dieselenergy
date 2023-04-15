<?php

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant read attributes', function () {
    $this->get(route('admin.attributes.index'))
        ->assertRedirect(route('admin.login'));
});

test('user can read attributes', function () {
    [$weight, $power] = Attribute::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'Weight'],
            ['name' => 'Power'],
        ))->create();

    $this->login()
        ->get(route('admin.attributes.index'))
        ->assertSuccessful()
        ->assertViewIs('admin.attributes.index')
        ->assertViewHas('attributes')
        ->assertSeeInOrder([$power->name, $weight->name]);
});
