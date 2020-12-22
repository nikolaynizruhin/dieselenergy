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

    /**
     * Height attribute.
     *
     * @var \App\Models\Attribute
     */
    private $height;

    /**
     * Weight attribute.
     *
     * @var \App\Models\Attribute
     */
    private $weight;

    protected function setUp(): void
    {
        parent::setUp();

        [$this->height, $this->weight] = Attribute::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Height'],
                ['name' => 'Weight'],
            ))->create();
    }

    /** @test */
    public function guest_cant_sort_attributes()
    {
        $this->get(route('admin.attributes.index', ['sort' => 'name']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_sort_attributes_ascending()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.attributes.index', ['sort' => 'name']))
            ->assertSuccessful()
            ->assertViewIs('admin.attributes.index')
            ->assertViewHas('attributes')
            ->assertSeeInOrder([$this->height->name, $this->weight->name]);
    }

    /** @test */
    public function admin_can_sort_attributes_descending()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.attributes.index', ['sort' => '-name']))
            ->assertSuccessful()
            ->assertViewIs('admin.attributes.index')
            ->assertViewHas('attributes')
            ->assertSeeInOrder([$this->weight->name, $this->height->name]);
    }
}
