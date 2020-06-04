<?php

namespace Tests\Feature\Specification;

use App\Attribute;
use App\Category;
use App\Specification;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteSpecificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_delete_specification()
    {
        $specification = factory(Specification::class)->create();

        $this->delete(route('specifications.destroy', $specification))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_delete_specification()
    {
        $user = factory(User::class)->create();
        $specification = factory(Specification::class)->create();

        $this->actingAs($user)
            ->from(route('categories.show', $specification->attributable_id))
            ->delete(route('specifications.destroy', $specification->id))
            ->assertRedirect(route('categories.show', $specification->attributable_id))
            ->assertSessionHas('status', 'Attribute was detached successfully!');

        $this->assertDatabaseMissing('attributables', ['id' => $specification->id]);
    }
}
