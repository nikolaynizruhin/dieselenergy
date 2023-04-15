<?php

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant sort categories', function () {
    $this->get(route('admin.categories.index', ['sort' => 'name']))
        ->assertRedirect(route('admin.login'));
});

test('admin can sort categories by name ascending', function () {
    [$ats, $generators] = Category::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'ATS'],
            ['name' => 'Generators'],
        ))->create();

    $this->login()
        ->get(route('admin.categories.index', ['sort' => 'name']))
        ->assertSuccessful()
        ->assertViewIs('admin.categories.index')
        ->assertViewHas('categories')
        ->assertSeeInOrder([$ats->name, $generators->name]);
});

test('admin can sort categories by name descending', function () {
    [$ats, $generators] = Category::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'ATS'],
            ['name' => 'Generators'],
        ))->create();

    $this->login()
        ->get(route('admin.categories.index', ['sort' => '-name']))
        ->assertSuccessful()
        ->assertViewIs('admin.categories.index')
        ->assertViewHas('categories')
        ->assertSeeInOrder([$generators->name, $ats->name]);
});

test('admin can sort categories by slug ascending', function () {
    [$ats, $generators] = Category::factory()
        ->count(2)
        ->state(new Sequence(
            ['slug' => 'ats'],
            ['slug' => 'generators'],
        ))->create();

    $this->login()
        ->get(route('admin.categories.index', ['sort' => 'slug']))
        ->assertSuccessful()
        ->assertViewIs('admin.categories.index')
        ->assertViewHas('categories')
        ->assertSeeInOrder([$ats->slug, $generators->slug]);
});

test('admin can sort categories by slug descending', function () {
    [$ats, $generators] = Category::factory()
        ->count(2)
        ->state(new Sequence(
            ['slug' => 'ats'],
            ['slug' => 'generators'],
        ))->create();

    $this->login()
        ->get(route('admin.categories.index', ['sort' => '-slug']))
        ->assertSuccessful()
        ->assertViewIs('admin.categories.index')
        ->assertViewHas('categories')
        ->assertSeeInOrder([$generators->slug, $ats->slug]);
});
