<?php

namespace Tests\Feature\Admin\Category;

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
        $this->get(route('admin.categories.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_category_page()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get(route('admin.categories.create'))
            ->assertViewIs('admin.categories.create');
    }

    /** @test */
    public function guest_cant_create_category()
    {
        $category = factory(Category::class)->raw();

        $this->post(route('admin.categories.store'), $category)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_category()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->raw();

        $this->actingAs($user)
            ->post(route('admin.categories.store'), $category)
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('status', trans('category.created'));

        $this->assertDatabaseHas('categories', $category);
    }

    /** @test */
    public function user_cant_create_category_without_name()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('admin.categories.store'))
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_category_with_integer_name()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('admin.categories.store'), [
                'name' => 1,
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_category_with_name_more_than_255_chars()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->post(route('admin.products.store'), [
                'name' => str_repeat('a', 256),
            ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_cant_create_category_with_existing_name()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();

        $this->actingAs($user)
            ->post(route('admin.categories.store'), [
                'name' => $category->name,
            ])->assertSessionHasErrors('name');
    }
}
