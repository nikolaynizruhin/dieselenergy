<?php

namespace Tests\Feature\Admin\Category;

use App\Models\Category;
use Tests\TestCase;

class DeleteCategoryTest extends TestCase
{
    /**
     * Category.
     */
    private Category $category;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->category = Category::factory()->create();
    }

    /** @test */
    public function guest_cant_delete_category(): void
    {
        $this->delete(route('admin.categories.destroy', $this->category))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_category(): void
    {
        $this->login()
            ->from(route('admin.categories.index'))
            ->delete(route('admin.categories.destroy', $this->category))
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('status', trans('category.deleted'));

        $this->assertModelMissing($this->category);
    }
}
