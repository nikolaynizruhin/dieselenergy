<?php

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant search categories', function () {
    $category = Category::factory()->create();

    $this->get(route('admin.categories.index', ['search' => $category->name]))
        ->assertRedirect(route('admin.login'));
});

test('user can search categories', function () {
    [$patrol, $diesel, $waterPumps] = Category::factory()
        ->count(3)
        ->state(new Sequence(
            ['name' => 'Patrol Generators'],
            ['name' => 'Diesel Generators'],
            ['name' => 'Water Pumps'],
        ))->create();

    $this->login()
        ->get(route('admin.categories.index', ['search' => 'Generators']))
        ->assertSeeInOrder([$diesel->name, $patrol->name])
        ->assertDontSee($waterPumps->name);
});
