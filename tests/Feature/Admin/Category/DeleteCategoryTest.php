<?php

namespace Tests\Feature\Admin\Category;

use App\Models\Category;
use Tests\TestCase;

class DeleteCategoryTest extends TestCase
{
    /** @test */
    public function guest_cant_delete_category()
    {
        $category = Category::factory()->create();

        $this->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_category()
    {
        $category = Category::factory()->create();

        $this->login()
            ->from(route('admin.categories.index'))
            ->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('status', trans('category.deleted'));

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
