<?php

namespace Tests\Feature\Admin\Category;

use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateCategoryTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function guest_cant_visit_update_category_page()
    {
        $category = Category::factory()->create();

        $this->get(route('admin.categories.edit', $category))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_category_page()
    {
        $category = Category::factory()->create();

        $this->login()
            ->get(route('admin.categories.edit', $category))
            ->assertViewIs('admin.categories.edit')
            ->assertViewHas('category', $category);
    }

    /** @test */
    public function guest_cant_update_category()
    {
        $category = Category::factory()->create();
        $stub = Category::factory()->raw();

        $this->put(route('admin.categories.update', $category), $stub)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_category()
    {
        $category = Category::factory()->create();
        $stub = Category::factory()->raw();

        $this->login()
            ->put(route('admin.categories.update', $category), $stub)
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('status', trans('category.updated'));

        $this->assertDatabaseHas('categories', $stub);
    }

    /** @test */
    public function user_cant_update_category_without_name()
    {
        $category = Category::factory()->create();
        $stub = Category::factory()->raw(['name' => null]);

        $this->login()
            ->from(route('admin.categories.edit', $category))
            ->put(route('admin.categories.update', $category), $stub)
            ->assertRedirect(route('admin.categories.edit', $category))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('categories', 1);
    }

    /** @test */
    public function user_cant_update_category_with_integer_name()
    {
        $category = Category::factory()->create();
        $stub = Category::factory()->raw(['name' => 1]);

        $this->login()
            ->from(route('admin.categories.edit', $category))
            ->put(route('admin.categories.update', $category), $stub)
            ->assertRedirect(route('admin.categories.edit', $category))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('categories', 1);
    }

    /** @test */
    public function user_cant_update_category_with_name_more_than_255_chars()
    {
        $category = Category::factory()->create();
        $stub = Category::factory()->raw(['name' => str_repeat('a', 256)]);

        $this->login()
            ->from(route('admin.categories.edit', $category))
            ->put(route('admin.categories.update', $category), $stub)
            ->assertRedirect(route('admin.categories.edit', $category))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('categories', 1);
    }

    /** @test */
    public function user_cant_update_category_with_existing_name()
    {
        $category = Category::factory()->create();
        $existing = Category::factory()->create();
        $stub = Category::factory()->raw(['name' => $existing]);

        $this->login()
            ->from(route('admin.categories.edit', $category))
            ->put(route('admin.categories.update', $category), $stub)
            ->assertRedirect(route('admin.categories.edit', $category))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('categories', 2);
    }

    /** @test */
    public function user_cant_update_category_with_existing_slug()
    {
        $category = Category::factory()->create();
        $existing = Category::factory()->create();
        $stub = Category::factory()->raw(['slug' => $existing]);

        $this->login()
            ->from(route('admin.categories.edit', $category))
            ->put(route('admin.categories.update', $category), $stub)
            ->assertRedirect(route('admin.categories.edit', $category))
            ->assertSessionHasErrors('slug');

        $this->assertDatabaseCount('categories', 2);
    }

    /** @test */
    public function user_cant_update_category_without_slug()
    {
        $category = Category::factory()->create();
        $stub = Category::factory()->raw(['slug' => null]);

        $this->login()
            ->from(route('admin.categories.edit', $category))
            ->put(route('admin.categories.update', $category), $stub)
            ->assertRedirect(route('admin.categories.edit', $category))
            ->assertSessionHasErrors('slug');

        $this->assertDatabaseCount('categories', 1);
    }

    /** @test */
    public function user_cant_update_category_with_integer_slug()
    {
        $category = Category::factory()->create();
        $stub = Category::factory()->raw(['slug' => 1]);

        $this->login()
            ->from(route('admin.categories.edit', $category))
            ->put(route('admin.categories.update', $category), $stub)
            ->assertRedirect(route('admin.categories.edit', $category))
            ->assertSessionHasErrors('slug');

        $this->assertDatabaseCount('categories', 1);
    }

    /** @test */
    public function user_cant_update_category_with_slug_more_than_255_chars()
    {
        $category = Category::factory()->create();
        $stub = Category::factory()->raw(['slug' => str_repeat('a', 256)]);

        $this->login()
            ->from(route('admin.categories.edit', $category))
            ->put(route('admin.categories.update', $category), $stub)
            ->assertRedirect(route('admin.categories.edit', $category))
            ->assertSessionHasErrors('slug');

        $this->assertDatabaseCount('categories', 1);
    }
}
