<?php

namespace Tests\Feature\Admin\Category;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class ReadCategoriesTest extends TestCase
{
    /** @test */
    public function guest_cant_read_categories(): void
    {
        $this->get(route('admin.categories.index'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_categories(): void
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
