<?php

namespace Tests\Feature\Category;

use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadCategoriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_categories()
    {
        $this->get(route('categories.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_read_categories()
    {
        $user = factory(User::class)->create();

        [$generators, $ats] = factory(Category::class, 2)->create();

        $this->actingAs($user)
            ->get(route('categories.index'))
            ->assertSuccessful()
            ->assertViewIs('categories.index')
            ->assertViewHas('categories')
            ->assertSee($generators->name)
            ->assertSee($ats->name);
    }
}
