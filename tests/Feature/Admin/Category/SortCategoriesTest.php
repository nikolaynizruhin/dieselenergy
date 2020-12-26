<?php

namespace Tests\Feature\Admin\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortCategoriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_sort_categories()
    {
        $this->get(route('admin.categories.index', ['sort' => 'name']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_sort_categories_by_name_ascending()
    {
        $user = User::factory()->create();

        [$ats, $generators] = Category::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'ATS'],
                ['name' => 'Generators'],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.categories.index', ['sort' => 'name']))
            ->assertSuccessful()
            ->assertViewIs('admin.categories.index')
            ->assertViewHas('categories')
            ->assertSeeInOrder([$ats->name, $generators->name]);
    }

    /** @test */
    public function admin_can_sort_categories_by_name_descending()
    {
        $user = User::factory()->create();

        [$ats, $generators] = Category::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'ATS'],
                ['name' => 'Generators'],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.categories.index', ['sort' => '-name']))
            ->assertSuccessful()
            ->assertViewIs('admin.categories.index')
            ->assertViewHas('categories')
            ->assertSeeInOrder([$generators->name, $ats->name]);
    }

    /** @test */
    public function admin_can_sort_categories_by_slug_ascending()
    {
        $user = User::factory()->create();

        [$ats, $generators] = Category::factory()
            ->count(2)
            ->state(new Sequence(
                ['slug' => 'ats'],
                ['slug' => 'generators'],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.categories.index', ['sort' => 'slug']))
            ->assertSuccessful()
            ->assertViewIs('admin.categories.index')
            ->assertViewHas('categories')
            ->assertSeeInOrder([$ats->slug, $generators->slug]);
    }

    /** @test */
    public function admin_can_sort_categories_by_slug_descending()
    {
        $user = User::factory()->create();

        [$ats, $generators] = Category::factory()
            ->count(2)
            ->state(new Sequence(
                ['slug' => 'ats'],
                ['slug' => 'generators'],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.categories.index', ['sort' => '-slug']))
            ->assertSuccessful()
            ->assertViewIs('admin.categories.index')
            ->assertViewHas('categories')
            ->assertSeeInOrder([$generators->slug, $ats->slug]);
    }
}
