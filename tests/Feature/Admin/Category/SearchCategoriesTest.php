<?php

namespace Tests\Feature\Admin\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
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
        [$patrol, $diesel, $waterPumps] = Category::factory()
            ->count(3)
            ->state(new Sequence(
                ['name' => 'Patrol Generators'],
                ['name' => 'Diesel Generators'],
                ['name' => 'Water Pumps'],
            ))->create();

        $this->login()
            ->get(route('admin.categories.index', ['search' => 'Generators']))
            ->assertSeeInOrder([$diesel->name, $patrol->name])
            ->assertDontSee($waterPumps->name);
    }
}
