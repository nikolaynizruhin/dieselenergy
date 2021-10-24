<?php

namespace Tests\Feature\Admin\Category;

use App\Models\Category;
use Illuminate\Support\Str;
use Tests\TestCase;

class CreateCategoryTest extends TestCase
{
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
                'name', fn () => $this->validFields(['name' => Category::factory()->create()->name]), 1,
            ],
            'Slug must be unique' => [
                'slug', fn () => $this->validFields(['slug' => Category::factory()->create()->slug]), 1,
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
     * Get valid category fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields($overrides = [])
    {
        return Category::factory()->raw($overrides);
    }
}
