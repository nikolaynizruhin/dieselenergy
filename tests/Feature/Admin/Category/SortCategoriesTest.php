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

    /**
     * Euro currency.
     *
     * @var \App\Models\Category
     */
    private $ats;

    /**
     * Dollar currency.
     *
     * @var \App\Models\Category
     */
    private $generators;

    protected function setUp(): void
    {
        parent::setUp();

        [$this->ats, $this->generators] = Category::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'ATS'],
                ['name' => 'Generators'],
            ))->create();
    }

    /** @test */
    public function guest_cant_sort_categories()
    {
        $this->get(route('admin.categories.index', ['sort' => 'name']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_sort_categories_ascending()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.categories.index', ['sort' => 'name']))
            ->assertSuccessful()
            ->assertViewIs('admin.categories.index')
            ->assertViewHas('categories')
            ->assertSeeInOrder([$this->ats->name, $this->generators->name]);
    }

    /** @test */
    public function admin_can_sort_categories_descending()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.categories.index', ['sort' => '-name']))
            ->assertSuccessful()
            ->assertViewIs('admin.categories.index')
            ->assertViewHas('categories')
            ->assertSeeInOrder([$this->generators->name, $this->ats->name]);
    }
}
