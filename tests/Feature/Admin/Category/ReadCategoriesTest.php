<?php

namespace Tests\Feature\Admin\Category;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Sequence;
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
        [$generators, $ats] = Category::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Generators'],
                ['name' => 'ATS'],
            ))->create();

        $this->login()
            ->get(route('admin.categories.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.categories.index')
            ->assertViewHas('categories')
            ->assertSeeInOrder([$ats->name, $generators->name]);
    }
}
