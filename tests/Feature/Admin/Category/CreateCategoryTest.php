<?php

namespace Tests\Feature\Admin\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCategoryTest extends TestCase
{
    use WithFaker;

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
        $category = Category::factory()->raw();

        $this->post(route('admin.categories.store'), $category)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_category()
    {
        $category = Category::factory()->raw();

        $this->login()
            ->post(route('admin.categories.store'), $category)
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('status', trans('category.created'));

        $this->assertDatabaseHas('categories', $category);
    }

    /** @test */
    public function user_cant_create_category_without_name()
    {
        $category = Category::factory()->raw(['name' => null]);

        $this->login()
            ->from(route('admin.categories.create'))
            ->post(route('admin.categories.store'), $category)
            ->assertRedirect(route('admin.categories.create'))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('categories', 0);
    }

    /** @test */
    public function user_cant_create_category_with_integer_name()
    {
        $category = User::factory()->raw(['name' => 1]);

        $this->login()
            ->from(route('admin.categories.create'))
            ->post(route('admin.categories.store'), $category)
            ->assertRedirect(route('admin.categories.create'))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('categories', 0);
    }

    /** @test */
    public function user_cant_create_category_with_name_more_than_255_chars()
    {
        $category = Category::factory()->raw(['name' => str_repeat('a', 256)]);

        $this->login()
            ->from(route('admin.categories.create'))
            ->post(route('admin.categories.store'), $category)
            ->assertRedirect(route('admin.categories.create'))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('categories', 0);
    }

    /** @test */
    public function user_cant_create_category_with_existing_name()
    {
        $category = Category::factory()->create();
        $stub = Category::factory()->raw(['name' => $category->name]);

        $this->login()
            ->from(route('admin.categories.create'))
            ->post(route('admin.categories.store'), $stub)
            ->assertRedirect(route('admin.categories.create'))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('categories', 1);
    }

    /** @test */
    public function user_cant_create_category_with_existing_slug()
    {
        $category = Category::factory()->create();
        $stub = Category::factory()->raw(['slug' => $category->slug]);

        $this->login()
            ->from(route('admin.categories.create'))
            ->post(route('admin.categories.store'), $stub)
            ->assertRedirect(route('admin.categories.create'))
            ->assertSessionHasErrors('slug');

        $this->assertDatabaseCount('categories', 1);
    }

    /** @test */
    public function user_cant_create_category_without_slug()
    {
        $category = Category::factory()->raw(['slug' => null]);

        $this->login()
            ->from(route('admin.categories.create'))
            ->post(route('admin.categories.store'), $category)
            ->assertRedirect(route('admin.categories.create'))
            ->assertSessionHasErrors('slug');

        $this->assertDatabaseCount('categories', 0);
    }

    /** @test */
    public function user_cant_create_category_with_integer_slug()
    {
        $category = Category::factory()->raw(['slug' => 1]);

        $this->login()
            ->from(route('admin.categories.create'))
            ->post(route('admin.categories.store'), $category)
            ->assertRedirect(route('admin.categories.create'))
            ->assertSessionHasErrors('slug');

        $this->assertDatabaseCount('categories', 0);
    }

    /** @test */
    public function user_cant_create_category_with_slug_more_than_255_chars()
    {
        $category = Category::factory()->raw(['slug' => str_repeat('a', 256)]);

        $this->login()
            ->from(route('admin.categories.create'))
            ->post(route('admin.categories.store'), $category)
            ->assertRedirect(route('admin.categories.create'))
            ->assertSessionHasErrors('slug');

        $this->assertDatabaseCount('categories', 0);
    }
}
