<?php

namespace Tests\Feature\Admin\Specification;

use App\Specification;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadSpecificationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_read_specifications()
    {
        $user = factory(User::class)->create();
        $specification = factory(Specification::class)->create();

        $this->actingAs($user)
            ->get(route('admin.categories.show', $specification->attributable_id))
            ->assertSuccessful()
            ->assertViewIs('admin.categories.show')
            ->assertViewHas('attributes')
            ->assertSee($specification->attribute->name);
    }
}
