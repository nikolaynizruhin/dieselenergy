<?php

namespace Tests\Feature\Admin\Specification;

use App\Models\Specification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteSpecificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_delete_specification()
    {
        $specification = Specification::factory()->create();

        $this->delete(route('admin.specifications.destroy', $specification))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_specification()
    {
        $user = User::factory()->create();
        $specification = Specification::factory()->create();

        $this->actingAs($user)
            ->from(route('admin.categories.show', $specification->category_id))
            ->delete(route('admin.specifications.destroy', $specification->id))
            ->assertRedirect(route('admin.categories.show', $specification->category_id))
            ->assertSessionHas('status', trans('specification.deleted'));

        $this->assertDatabaseMissing('attribute_category', ['id' => $specification->id]);
    }
}
