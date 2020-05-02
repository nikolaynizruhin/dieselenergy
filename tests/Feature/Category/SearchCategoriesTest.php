<?php

namespace Tests\Feature\Category;

use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchCategoriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_categories()
    {
        $category = factory(Category::class)->create();

        $this->get(route('categories.index', ['search' => $category->name]))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_search_categories()
    {
        $user = factory(User::class)->create();

        $generators = factory(Category::class)->create(['name' => 'Generators']);
        $ats = factory(Category::class)->create(['name' => 'ATS']);

        $this->actingAs($user)
            ->get(route('categories.index', ['search' => $generators->name]))
            ->assertSee($generators->name)
            ->assertDontSee($ats->name);
    }
}
