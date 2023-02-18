<?php

namespace Tests\Feature\Admin\Category;

use App\Models\Category;
use Tests\TestCase;

class UpdateCategoryTest extends TestCase
{
    use HasValidation;

    /**
     * Category.
     */
    private Category $category;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->category = Category::factory()->create();
    }

    /** @test */
    public function guest_cant_visit_update_category_page(): void
    {
        $this->get(route('admin.categories.edit', $this->category))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_category_page(): void
    {
        $this->login()
            ->get(route('admin.categories.edit', $this->category))
            ->assertViewIs('admin.categories.edit')
            ->assertViewHas('category', $this->category);
    }

    /** @test */
    public function guest_cant_update_category(): void
    {
        $this->put(route('admin.categories.update', $this->category), self::validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_category(): void
    {
        $this->login()
            ->put(route('admin.categories.update', $this->category), $fields = self::validFields())
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('status', trans('category.updated'));

        $this->assertDatabaseHas('categories', $fields);
    }

    /**
     * @test
     *
     * @dataProvider validationProvider
     */
    public function user_cant_update_category_with_invalid_data(string $field, callable $data, int $count = 1): void
    {
        $this->login()
            ->from(route('admin.categories.edit', $this->category))
            ->put(route('admin.categories.update', $this->category), $data())
            ->assertRedirect(route('admin.categories.edit', $this->category))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('categories', $count);
    }

    public static function validationProvider(): array
    {
        return self::provider(2);
    }
}
