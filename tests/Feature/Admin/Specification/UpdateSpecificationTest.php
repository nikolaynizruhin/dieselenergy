<?php

namespace Tests\Feature\Admin\Specification;

use App\Models\Specification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateSpecificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_visit_update_specification_page()
    {
        $specification = Specification::factory()->create();

        $this->get(route('admin.specifications.edit', $specification))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_specification_page()
    {
        $user = User::factory()->create();
        $specification = Specification::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.specifications.edit', $specification))
            ->assertViewIs('admin.specifications.edit');
    }

    /** @test */
    public function guest_cant_update_specification()
    {
        $specification = Specification::factory()->create();

        $this->put(route('admin.specifications.update', $specification))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_specification()
    {
        $user = User::factory()->create();

        $specification = Specification::factory()->create();
        $stub = Specification::factory()->make()->toArray();

        $this->actingAs($user)
            ->put(route('admin.specifications.update', $specification), $stub)
            ->assertRedirect(route('admin.categories.show', $stub['category_id']))
            ->assertSessionHas('status', trans('specification.updated'));

        $this->assertDatabaseHas('attribute_category', $stub);
    }

    /** @test */
    public function user_cant_update_specification_without_category()
    {
        $user = User::factory()->create();

        $specification = Specification::factory()->create();
        $stub = Specification::factory()->make(['category_id' => null])->toArray();

        $this->actingAs($user)
            ->put(route('admin.specifications.update', $specification), $stub)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_update_specification_with_string_category()
    {
        $user = User::factory()->create();

        $specification = Specification::factory()->create();
        $stub = Specification::factory()->make(['category_id' => 'string'])->toArray();

        $this->actingAs($user)
            ->put(route('admin.specifications.update', $specification), $stub)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_update_specification_with_nonexistent_category()
    {
        $user = User::factory()->create();

        $specification = Specification::factory()->create();
        $stub = Specification::factory()->make(['category_id' => 10])->toArray();

        $this->actingAs($user)
            ->put(route('admin.specifications.update', $specification), $stub)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_update_specification_without_attribute()
    {
        $user = User::factory()->create();

        $specification = Specification::factory()->create();
        $stub = Specification::factory()->make(['attribute_id' => null])->toArray();

        $this->actingAs($user)
            ->put(route('admin.specifications.update', $specification), $stub)
            ->assertSessionHasErrors('attribute_id');
    }

    /** @test */
    public function user_cant_update_specification_with_string_attribute()
    {
        $user = User::factory()->create();

        $specification = Specification::factory()->create();
        $stub = Specification::factory()->make(['attribute_id' => 'string'])->toArray();

        $this->actingAs($user)
            ->put(route('admin.specifications.update', $specification), $stub)
            ->assertSessionHasErrors('attribute_id');
    }

    /** @test */
    public function user_cant_update_specification_with_nonexistent_attribute()
    {
        $user = User::factory()->create();

        $specification = Specification::factory()->create();
        $stub = Specification::factory()->make(['attribute_id' => 10])->toArray();

        $this->actingAs($user)
            ->put(route('admin.specifications.update', $specification), $stub)
            ->assertSessionHasErrors('attribute_id');
    }
}
