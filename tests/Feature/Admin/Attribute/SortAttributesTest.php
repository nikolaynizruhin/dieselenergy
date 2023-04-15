<?php

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('guest cant sort attributes', function () {
    $this->get(route('admin.attributes.index', ['sort' => 'name']))
        ->assertRedirect(route('admin.login'));
});

test('admin can sort attributes by name ascending', function () {
    [$height, $weight] = Attribute::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'Height'],
            ['name' => 'Weight'],
        ))->create();

    $this->login()
        ->get(route('admin.attributes.index', ['sort' => 'name']))
        ->assertSuccessful()
        ->assertViewIs('admin.attributes.index')
        ->assertViewHas('attributes')
        ->assertSeeInOrder([$height->name, $weight->name]);
});

test('admin can sort attributes by name descending', function () {
    [$height, $weight] = Attribute::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'Height'],
            ['name' => 'Weight'],
        ))->create();

    $this->login()
        ->get(route('admin.attributes.index', ['sort' => '-name']))
        ->assertSuccessful()
        ->assertViewIs('admin.attributes.index')
        ->assertViewHas('attributes')
        ->assertSeeInOrder([$weight->name, $height->name]);
});

test('admin can sort attributes by measure ascending', function () {
    [$height, $weight] = Attribute::factory()
        ->count(2)
        ->state(new Sequence(
            ['measure' => 'A'],
            ['measure' => 'V'],
        ))->create();

    $this->login()
        ->get(route('admin.attributes.index', ['sort' => 'measure']))
        ->assertSuccessful()
        ->assertViewIs('admin.attributes.index')
        ->assertViewHas('attributes')
        ->assertSeeInOrder([$height->measure, $weight->measure]);
});

test('admin can sort attributes by measure descending', function () {
    [$height, $weight] = Attribute::factory()
        ->count(2)
        ->state(new Sequence(
            ['measure' => 'A'],
            ['measure' => 'V'],
        ))->create();

    $this->login()
        ->get(route('admin.attributes.index', ['sort' => '-measure']))
        ->assertSuccessful()
        ->assertViewIs('admin.attributes.index')
        ->assertViewHas('attributes')
        ->assertSeeInOrder([$weight->measure, $height->measure]);
});
