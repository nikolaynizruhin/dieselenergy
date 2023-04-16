<?php

use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Sequence;

beforeEach(function () {
    [$this->height, $this->width] = Attribute::factory()
        ->count(2)
        ->state(new Sequence(
            ['name' => 'height attribute'],
            ['name' => 'width attribute'],
        ))->create();

    $this->category = Category::factory()->create();

    $this->category->attributes()->attach([$this->width->id, $this->height->id]);
});

test('guest cant sort specification', function () {
    $this->get(route('admin.categories.show', [
        'category' => $this->category,
        'search' => 'width',
    ]))->assertRedirect(route('admin.login'));
});

test('user can sort specifications ascending', function () {
    $this->login()
        ->get(route('admin.categories.show', [
            'category' => $this->category,
            'sort' => 'name',
        ]))->assertSuccessful()
        ->assertSeeInOrder([$this->height->name, $this->width->name]);
});

test('user can sort specifications descending', function () {
    $this->login()
        ->get(route('admin.categories.show', [
            'category' => $this->category,
            'sort' => '-name',
        ]))->assertSuccessful()
        ->assertSeeInOrder([$this->width->name, $this->height->name]);
});
