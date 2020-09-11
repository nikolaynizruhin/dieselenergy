<?php

namespace Tests\Feature\Admin\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchCategoriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_categories()
    {
        $category = Category::factory()->create();

        $this->get(route('admin.categories.index', ['search' => $category->name]))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_categories()
    {
        $user = User::factory()->create();

        $patrol = Category::factory()->create(['name' => 'Patrol Generators']);
        $diesel = Category::factory()->create(['name' => 'Diesel Generators']);
        $waterPumps = Category::factory()->create(['name' => 'Water Pumps']);

        $this->actingAs($user)
            ->get(route('admin.categories.index', ['search' => 'Generators']))
            ->assertSeeInOrder([$diesel->name, $patrol->name])
            ->assertDontSee($waterPumps->name);
    }
}
