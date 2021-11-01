<?php

namespace Tests\Feature\Admin\Category;

use Tests\TestCase;

class CreateCategoryTest extends TestCase
{
    use HasValidation;

    /** @test */
    public function guest_cant_visit_create_category_page()
    {
        $this->get(route('admin.categories.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_category_page()
    {
        $this->login()
            ->get(route('admin.categories.create'))
            ->assertViewIs('admin.categories.create');
    }

    /** @test */
    public function guest_cant_create_category()
    {
        $this->post(route('admin.categories.store'), $this->validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_category()
    {
        $this->login()
            ->post(route('admin.categories.store'), $fields = $this->validFields())
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('status', trans('category.created'));

        $this->assertDatabaseHas('categories', $fields);
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_create_category_with_invalid_data($field, $data, $count = 0)
    {
        $this->login()
            ->from(route('admin.categories.create'))
            ->post(route('admin.categories.store'), $data())
            ->assertRedirect(route('admin.categories.create'))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('categories', $count);
    }

    public function validationProvider(): array
    {
        return $this->provider();
    }
}
