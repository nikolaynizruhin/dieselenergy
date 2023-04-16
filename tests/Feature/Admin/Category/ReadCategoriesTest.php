<?php

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant read categories', function () {
    $this->get(route('admin.categories.index'))
        ->assertRedirect(route('admin.login'));
});

test('user can read categories', function () {
    [$generators, $ats] = Category::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'Generators'],
            ['name' => 'ATS'],
        ))->create();

    $this->login()
        ->get(route('admin.categories.index'))
        ->assertSuccessful()
        ->assertViewIs('admin.categories.index')
        ->assertViewHas('categories')
        ->assertSeeInOrder([$ats->name, $generators->name]);
});
