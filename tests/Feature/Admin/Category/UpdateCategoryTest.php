<?php

namespace Tests\Feature\Admin\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateCategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

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
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.categories.edit', $category))
            ->assertViewIs('admin.categories.edit')
            ->assertViewHas('category', $category);
    }

    /** @test */
    public function guest_cant_update_category()
    {
        $category = Category::factory()->create();

        $this->put(route('admin.categories.update', $category), [
            'name' => $this->faker->word,
        ])->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_category()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $stub = Category::factory()->raw();

        $this->actingAs($user)
            ->put(route('admin.categories.update', $category), $stub)
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('status', trans('category.updated'));

        $this->assertDatabaseHas('categories', $stub);
    }

    /** @test */
    public function user_cant_update_category_without_name()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $this->actingAs($user)
            ->put(route('admin.categories.update', $category), [
                'name' => null,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_category_with_integer_name()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $this->actingAs($user)
            ->put(route('admin.categories.update', $category), [
                'name' => 1,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_category_with_name_more_than_255_chars()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $this->actingAs($user)
            ->put(route('admin.categories.update', $category), [
                'name' => str_repeat('a', 256),
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_category_with_existing_name()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $existing = Category::factory()->create();

        $this->actingAs($user)
            ->put(route('admin.categories.update', $category), [
                'name' => $existing,
            ])->assertSessionHasErrors('name');
    }
}
