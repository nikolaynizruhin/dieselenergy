<?php

namespace Tests\Feature\Admin\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_create_category_page()
    {
        $this->get(route('admin.categories.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_category_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
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
        $user = User::factory()->create();
        $category = Category::factory()->raw();

        $this->actingAs($user)
            ->post(route('admin.categories.store'), $category)
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('status', trans('category.created'));

        $this->assertDatabaseHas('categories', $category);
    }

    /** @test */
    public function user_cant_create_category_without_name()
    {
        $user = User::factory()->create();
        $category = Category::factory()->raw(['name' => null]);

        $this->actingAs($user)
            ->post(route('admin.categories.store'), $category)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_category_with_integer_name()
    {
        $user = User::factory()->create();
        $category = User::factory()->raw(['name' => 1]);

        $this->actingAs($user)
            ->post(route('admin.categories.store'), $category)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_category_with_name_more_than_255_chars()
    {
        $user = User::factory()->create();
        $category = Category::factory()->raw(['name' => str_repeat('a', 256)]);

        $this->actingAs($user)
            ->post(route('admin.categories.store'), $category)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_category_with_existing_name()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $stub = Category::factory()->raw(['name' => $category->name]);

        $this->actingAs($user)
            ->post(route('admin.categories.store'), $stub)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_category_with_existing_slug()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $stub = Category::factory()->raw(['slug' => $category->slug]);

        $this->actingAs($user)
            ->post(route('admin.categories.store'), $stub)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function user_cant_create_category_without_slug()
    {
        $user = User::factory()->create();
        $category = Category::factory()->raw(['slug' => null]);

        $this->actingAs($user)
            ->post(route('admin.categories.store'), $category)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function user_cant_create_category_with_integer_slug()
    {
        $user = User::factory()->create();
        $category = Category::factory()->raw(['slug' => 1]);

        $this->actingAs($user)
            ->post(route('admin.categories.store'), $category)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function user_cant_create_category_with_slug_more_than_255_chars()
    {
        $user = User::factory()->create();
        $category = Category::factory()->raw(['slug' => str_repeat('a', 256)]);

        $this->actingAs($user)
            ->post(route('admin.categories.store'), $category)
            ->assertSessionHasErrors('slug');
    }
}
