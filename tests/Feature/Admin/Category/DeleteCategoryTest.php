<?php

namespace Tests\Feature\Admin\Category;

use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_delete_category()
    {
        $category = factory(Category::class)->create();

        $this->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_category()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();

        $this->actingAs($user)
            ->from(route('admin.categories.index'))
            ->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('status', 'Category was deleted successfully!');

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
