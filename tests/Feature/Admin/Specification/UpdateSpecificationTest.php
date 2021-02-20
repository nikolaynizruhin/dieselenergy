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

        $specification = Specification::factory()->create();

        $this->login()
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


        $specification = Specification::factory()->create();
        $stub = Specification::factory()->raw();

        $this->login()
            ->put(route('admin.specifications.update', $specification), $stub)
            ->assertRedirect(route('admin.categories.show', $stub['category_id']))
            ->assertSessionHas('status', trans('specification.updated'));

        $this->assertDatabaseHas('attribute_category', $stub);
    }

    /** @test */
    public function user_cant_update_specification_without_category()
    {


        $specification = Specification::factory()->create();
        $stub = Specification::factory()->raw(['category_id' => null]);

        $this->login()
            ->put(route('admin.specifications.update', $specification), $stub)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_update_specification_with_string_category()
    {


        $specification = Specification::factory()->create();
        $stub = Specification::factory()->raw(['category_id' => 'string']);

        $this->login()
            ->put(route('admin.specifications.update', $specification), $stub)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_update_specification_with_nonexistent_category()
    {


        $specification = Specification::factory()->create();
        $stub = Specification::factory()->raw(['category_id' => 10]);

        $this->login()
            ->put(route('admin.specifications.update', $specification), $stub)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_update_specification_without_attribute()
    {


        $specification = Specification::factory()->create();
        $stub = Specification::factory()->raw(['attribute_id' => null]);

        $this->login()
            ->put(route('admin.specifications.update', $specification), $stub)
            ->assertSessionHasErrors('attribute_id');
    }

    /** @test */
    public function user_cant_update_specification_with_string_attribute()
    {


        $specification = Specification::factory()->create();
        $stub = Specification::factory()->raw(['attribute_id' => 'string']);

        $this->login()
            ->put(route('admin.specifications.update', $specification), $stub)
            ->assertSessionHasErrors('attribute_id');
    }

    /** @test */
    public function user_cant_update_specification_with_nonexistent_attribute()
    {


        $specification = Specification::factory()->create();
        $stub = Specification::factory()->raw(['attribute_id' => 10]);

        $this->login()
            ->put(route('admin.specifications.update', $specification), $stub)
            ->assertSessionHasErrors('attribute_id');
    }
}
