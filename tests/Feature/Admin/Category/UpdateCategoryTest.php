<?php

namespace Tests\Feature\Admin\Category;

use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class UpdateCategoryTest extends TestCase
{
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

    public function validationProvider(): array
    {
        return [
            'Name is required' => [
                'name', fn () => $this->validFields(['name' => null]),
            ],
            'Name cant be an integer' => [
                'name', fn () => $this->validFields(['name' => 1]),
            ],
            'Name cant be more than 255 chars' => [
                'name', fn () => $this->validFields(['name' => Str::random(256)]),
            ],
            'Name must be unique' => [
                'name', fn () => $this->validFields(['name' => Category::factory()->create()->name]), 2,
            ],
            'Slug must be unique' => [
                'slug', fn () => $this->validFields(['slug' => Category::factory()->create()->slug]), 2,
            ],
            'Slug is required' => [
                'slug', fn () => $this->validFields(['slug' => null]),
            ],
            'Slug cant be an integer' => [
                'slug', fn () => $this->validFields(['slug' => 1]),
            ],
            'Slug cant be more than 255 chars' => [
                'slug', fn () => $this->validFields(['slug' => Str::random(256)]),
            ],
        ];
    }

    /**
     * Get valid contact fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields($overrides = [])
    {
        return Category::factory()->raw($overrides);
    }
}
