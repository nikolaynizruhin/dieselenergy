<?php

namespace Tests\Feature\Admin\Specification;

use App\Specification;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateSpecificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_visit_update_specification_page()
    {
        $specification = factory(Specification::class)->create();

        $this->get(route('admin.specifications.edit', $specification))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_specification_page()
    {
        $user = factory(User::class)->create();
        $specification = factory(Specification::class)->create();

        $this->actingAs($user)
            ->get(route('admin.specifications.edit', $specification))
            ->assertViewIs('admin.specifications.edit');
    }

    /** @test */
    public function guest_cant_update_specification()
    {
        $specification = factory(Specification::class)->create();

        $this->put(route('admin.specifications.update', $specification))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_specification()
    {
        $user = factory(User::class)->create();

        $specification = factory(Specification::class)->create();
        $stub = factory(Specification::class)->raw();

        $this->actingAs($user)
            ->put(route('admin.specifications.update', $specification), [
                'category_id' => $stub['attributable_id'],
                'attribute_id' => $stub['attribute_id'],
                'is_featured' => $stub['is_featured'],
            ])->assertRedirect(route('admin.categories.show', $stub['attributable_id']))
            ->assertSessionHas('status', trans('specification.updated'));

        $this->assertDatabaseHas('attributables', $stub);
    }

    /** @test */
    public function user_cant_update_specification_without_category()
    {
        $user = factory(User::class)->create();

        $specification = factory(Specification::class)->create();
        $stub = factory(Specification::class)->raw();

        $this->actingAs($user)
            ->put(route('admin.specifications.update', $specification), [
                'attribute_id' => $stub['attribute_id'],
                'is_featured' => $stub['is_featured'],
                'category_id' => null,
            ])->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_update_specification_with_string_category()
    {
        $user = factory(User::class)->create();

        $specification = factory(Specification::class)->create();
        $stub = factory(Specification::class)->raw();

        $this->actingAs($user)
            ->put(route('admin.specifications.update', $specification), [
                'attribute_id' => $stub['attribute_id'],
                'is_featured' => $stub['is_featured'],
                'category_id' => 'string',
            ])->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_update_specification_with_nonexistent_category()
    {
        $user = factory(User::class)->create();

        $specification = factory(Specification::class)->create();
        $stub = factory(Specification::class)->raw();

        $this->actingAs($user)
            ->put(route('admin.specifications.update', $specification), [
                'attribute_id' => $stub['attribute_id'],
                'is_featured' => $stub['is_featured'],
                'category_id' => 10,
            ])->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_update_specification_without_attribute()
    {
        $user = factory(User::class)->create();

        $specification = factory(Specification::class)->create();
        $stub = factory(Specification::class)->raw();

        $this->actingAs($user)
            ->put(route('admin.specifications.update', $specification), [
                'attribute_id' => null,
                'is_featured' => $stub['is_featured'],
                'category_id' => $stub['attributable_id'],
            ])->assertSessionHasErrors('attribute_id');
    }

    /** @test */
    public function user_cant_update_specification_with_string_attribute()
    {
        $user = factory(User::class)->create();

        $specification = factory(Specification::class)->create();
        $stub = factory(Specification::class)->raw();

        $this->actingAs($user)
            ->put(route('admin.specifications.update', $specification), [
                'attribute_id' => 'string',
                'is_featured' => $stub['is_featured'],
                'category_id' => $stub['attributable_id'],
            ])->assertSessionHasErrors('attribute_id');
    }

    /** @test */
    public function user_cant_update_specification_with_nonexistent_attribute()
    {
        $user = factory(User::class)->create();

        $specification = factory(Specification::class)->create();
        $stub = factory(Specification::class)->raw();

        $this->actingAs($user)
            ->put(route('admin.specifications.update', $specification), [
                'attribute_id' => 10,
                'is_featured' => $stub['is_featured'],
                'category_id' => $stub['attributable_id'],
            ])->assertSessionHasErrors('attribute_id');
    }
}
