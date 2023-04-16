<?php

namespace Tests\Feature\Admin\Specification;

use App\Models\Category;
use App\Models\Specification;

test('guest cant visit create specification page', function () {
    $this->get(route('admin.specifications.create'))
        ->assertRedirect(route('admin.login'));
});

test('user can visit create specification page', function () {
    $category = Category::factory()->create();

    $this->login()
        ->get(route('admin.specifications.create', ['category_id' => $category->id]))
        ->assertViewIs('admin.specifications.create');
});

test('guest cant create specification', function () {
    $this->post(route('admin.specifications.store'), validFields())
        ->assertRedirect(route('admin.login'));
});

test('user can create specification', function () {
    $this->login()
        ->post(route('admin.specifications.store'), $fields = validFields())
        ->assertRedirect(route('admin.categories.show', $fields['category_id']))
        ->assertSessionHas('status', trans('specification.created'));

    $this->assertDatabaseHas('attribute_category', $fields);
});

test('user cant create specification with invalid data', function (string $field, callable $data, int $count = 0) {
    $this->login()
        ->from(route('admin.specifications.create'))
        ->post(route('admin.specifications.store'), $data())
        ->assertRedirect(route('admin.specifications.create'))
        ->assertSessionHasErrors($field);

    $this->assertDatabaseCount('attribute_category', $count);
})->with([
    'Category is required' => [
        'category_id', fn () => validFields(['category_id' => null]),
    ],
    'Category cant be string' => [
        'category_id', fn () => validFields(['category_id' => 'string']),
    ],
    'Category must exists' => [
        'category_id', fn () => validFields(['category_id' => 10]),
    ],
    'Attribute is required' => [
        'attribute_id', fn () => validFields(['attribute_id' => null]),
    ],
    'Attribute cant be string' => [
        'attribute_id', fn () => validFields(['attribute_id' => 'string']),
    ],
    'Attribute must exists' => [
        'attribute_id', fn () => validFields(['attribute_id' => 10]),
    ],
    'Specification must be unique' => [
        'attribute_id', fn () => Specification::factory()->create()->toArray(), 1,
    ],
]);

function validFields(array $overrides = []): array
{
    return Specification::factory()->raw($overrides);
}
