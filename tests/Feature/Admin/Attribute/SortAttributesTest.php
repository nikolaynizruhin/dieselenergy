<?php

namespace Tests\Feature\Admin\Attribute;

use App\Models\Attribute;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortAttributesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_sort_attributes()
    {
        $this->get(route('admin.attributes.index', ['sort' => 'name']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_sort_attributes_by_name_ascending()
    {
        [$height, $weight] = Attribute::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Height'],
                ['name' => 'Weight'],
            ))->create();

        $this->login()
            ->get(route('admin.attributes.index', ['sort' => 'name']))
            ->assertSuccessful()
            ->assertViewIs('admin.attributes.index')
            ->assertViewHas('attributes')
            ->assertSeeInOrder([$height->name, $weight->name]);
    }

    /** @test */
    public function admin_can_sort_attributes_by_name_descending()
    {
        [$height, $weight] = Attribute::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Height'],
                ['name' => 'Weight'],
            ))->create();

        $this->login()
            ->get(route('admin.attributes.index', ['sort' => '-name']))
            ->assertSuccessful()
            ->assertViewIs('admin.attributes.index')
            ->assertViewHas('attributes')
            ->assertSeeInOrder([$weight->name, $height->name]);
    }

    /** @test */
    public function admin_can_sort_attributes_by_measure_ascending()
    {
        [$height, $weight] = Attribute::factory()
            ->count(2)
            ->state(new Sequence(
                ['measure' => 'A'],
                ['measure' => 'V'],
            ))->create();

        $this->login()
            ->get(route('admin.attributes.index', ['sort' => 'measure']))
            ->assertSuccessful()
            ->assertViewIs('admin.attributes.index')
            ->assertViewHas('attributes')
            ->assertSeeInOrder([$height->measure, $weight->measure]);
    }

    /** @test */
    public function admin_can_sort_attributes_by_measure_descending()
    {
        [$height, $weight] = Attribute::factory()
            ->count(2)
            ->state(new Sequence(
                ['measure' => 'A'],
                ['measure' => 'V'],
            ))->create();

        $this->login()
            ->get(route('admin.attributes.index', ['sort' => '-measure']))
            ->assertSuccessful()
            ->assertViewIs('admin.attributes.index')
            ->assertViewHas('attributes')
            ->assertSeeInOrder([$weight->measure, $height->measure]);
    }
}
