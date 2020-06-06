<?php

namespace Tests\Feature\Admin\Category;

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
        $this->get(route('admin.categories.index'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_categories()
    {
        $user = factory(User::class)->create();

        $generators = factory(Category::class)->create(['name' => 'Generators']);
        $ats = factory(Category::class)->create(['name' => 'ATS']);

        $this->actingAs($user)
            ->get(route('admin.categories.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.categories.index')
            ->assertViewHas('categories')
            ->assertSeeInOrder([$ats->name, $generators->name]);
    }
}
