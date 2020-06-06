<?php

namespace Tests\Feature\Admin\Category;

use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchCategoriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_categories()
    {
        $category = factory(Category::class)->create();

        $this->get(route('admin.categories.index', ['search' => $category->name]))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_categories()
    {
        $user = factory(User::class)->create();

        $patrol = factory(Category::class)->create(['name' => 'Patrol Generators']);
        $diesel = factory(Category::class)->create(['name' => 'Diesel Generators']);
        $waterPumps = factory(Category::class)->create(['name' => 'Water Pumps']);

        $this->actingAs($user)
            ->get(route('admin.categories.index', ['search' => 'Generators']))
            ->assertSeeInOrder([$diesel->name, $patrol->name])
            ->assertDontSee($waterPumps->name);
    }
}
