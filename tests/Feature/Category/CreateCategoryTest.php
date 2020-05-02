<?php

namespace Tests\Feature\Category;

use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCategoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_create_category_page()
    {
        $this->get(route('categories.create'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_visit_create_category_page()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get(route('categories.create'))
            ->assertViewIs('categories.create');
    }

    /** @test */
    public function guest_cant_create_category()
    {
        $category = factory(Category::class)->raw();

        $this->post(route('categories.store'), $category)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_create_category()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->raw();

        $this->actingAs($user)
            ->post(route('categories.store'), $category)
            ->assertRedirect(route('categories.index'))
            ->assertSessionHas('status', 'Category was created successfully!');

        $this->assertDatabaseHas('categories', $category);
    }

    /** @test */
    public function user_cant_create_category_without_name()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('categories.store'))
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_category_with_integer_name()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('categories.store'), [
                'name' => 1,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_category_with_name_more_than_255_chars()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('products.store'), [
                'name' => str_repeat('a', 256),
            ])->assertSessionHasErrors('name');
    }
}
