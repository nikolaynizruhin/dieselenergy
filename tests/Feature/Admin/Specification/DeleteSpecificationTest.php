<?php

namespace Tests\Feature\Admin\Specification;

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

        $this->delete(route('admin.specifications.destroy', $specification))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_specification()
    {
        $user = factory(User::class)->create();
        $specification = factory(Specification::class)->create();

        $this->actingAs($user)
            ->from(route('admin.categories.show', $specification->attributable_id))
            ->delete(route('admin.specifications.destroy', $specification->id))
            ->assertRedirect(route('admin.categories.show', $specification->attributable_id))
            ->assertSessionHas('status', 'Attribute was detached successfully!');

        $this->assertDatabaseMissing('attributables', ['id' => $specification->id]);
    }
}
