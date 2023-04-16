<?php

use App\Models\Specification;

beforeEach(function () {
    $this->specification = Specification::factory()->regular()->create();
});

test('guest cant update specification feature', function () {
    $this->put(route('admin.specifications.feature.update', $this->specification))
        ->assertRedirect(route('admin.login'));
});

test('user can update specification feature', function () {
    $this->login()
        ->put(route('admin.specifications.feature.update', $this->specification))
        ->assertRedirect(route('admin.categories.show', $this->specification->category_id))
        ->assertSessionHas('status', trans('specification.updated'));

    $this->assertTrue($this->specification->fresh()->is_featured);
});
