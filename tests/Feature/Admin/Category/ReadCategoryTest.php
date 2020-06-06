<?php

namespace Tests\Feature\Admin\Category;

use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_category()
    {
        $category = factory(Category::class)->create();

        $this->get(route('admin.categories.show', $category))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_category()
    {
        $user = factory(User::class)->create();

        $category = factory(Category::class)->create();

        $this->actingAs($user)
            ->get(route('admin.categories.show', $category))
            ->assertSuccessful()
            ->assertViewIs('admin.categories.show')
            ->assertViewHas('category')
            ->assertSee($category->name);
    }
}
