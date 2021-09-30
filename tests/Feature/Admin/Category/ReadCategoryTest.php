<?php

namespace Tests\Feature\Admin\Category;

use App\Models\Category;
use Tests\TestCase;

class ReadCategoryTest extends TestCase
{
    /** @test */
    public function guest_cant_read_category()
    {
        $category = Category::factory()->create();

        $this->get(route('admin.categories.show', $category))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_category()
    {
        $category = Category::factory()->create();

        $this->login()
            ->get(route('admin.categories.show', $category))
            ->assertSuccessful()
            ->assertViewIs('admin.categories.show')
            ->assertViewHas('category')
            ->assertSee($category->name);
    }
}
