<?php

namespace Tests\Feature\Admin\Category;

use App\Models\Category;
use Tests\TestCase;

class UpdateCategoryTest extends TestCase
{
    use HasValidation;

    /**
     * Product.
     *
     * @var \App\Models\Category
     */
    private $category;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->category = Category::factory()->create();
    }

    /** @test */
    public function guest_cant_visit_update_category_page()
    {
        $this->get(route('admin.categories.edit', $this->category))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_category_page()
    {
        $this->login()
            ->get(route('admin.categories.edit', $this->category))
            ->assertViewIs('admin.categories.edit')
            ->assertViewHas('category', $this->category);
    }

    /** @test */
    public function guest_cant_update_category()
    {
        $this->put(route('admin.categories.update', $this->category), $this->validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_category()
    {
        $this->login()
            ->put(route('admin.categories.update', $this->category), $fields = $this->validFields())
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('status', trans('category.updated'));

        $this->assertDatabaseHas('categories', $fields);
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_update_category_with_invalid_data($field, $data, $count = 1)
    {
        $this->login()
            ->from(route('admin.categories.edit', $this->category))
            ->put(route('admin.categories.update', $this->category), $data())
            ->assertRedirect(route('admin.categories.edit', $this->category))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('categories', $count);
    }

    public function validationProvider()
    {
        return $this->provider(2);
    }
}
