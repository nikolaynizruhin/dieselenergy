<?php

namespace Tests\Feature\Category;

use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateCategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_update_category_page()
    {
        $category = factory(Category::class)->create();

        $this->get(route('categories.edit', $category))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_visit_update_category_page()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();

        $this->actingAs($user)
            ->get(route('categories.edit', $category))
            ->assertViewIs('categories.edit')
            ->assertViewHas('category', $category);
    }

    /** @test */
    public function guest_cant_update_category()
    {
        $category = factory(Category::class)->create();

        $this->put(route('categories.update', $category), [
            'name' => $this->faker->sentence,
        ])->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_update_category()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();
        $stub = factory(Category::class)->raw();

        $this->actingAs($user)
            ->put(route('categories.update', $category), $stub)
            ->assertRedirect(route('categories.index'))
            ->assertSessionHas('status', 'Category was updated successfully!');

        $this->assertDatabaseHas('categories', $stub);
    }

    /** @test */
    public function user_cant_update_category_without_name()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();

        $this->actingAs($user)
            ->put(route('categories.update', $category), [
                'name' => null,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_category_with_integer_name()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();

        $this->actingAs($user)
            ->put(route('categories.update', $category), [
                'name' => 1,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_update_category_with_name_more_than_255_chars()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();

        $this->actingAs($user)
            ->put(route('categories.update', $category), [
                'name' => str_repeat('a', 256),
            ])->assertSessionHasErrors('name');
    }
}
