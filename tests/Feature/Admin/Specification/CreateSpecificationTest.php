<?php

namespace Tests\Feature\Admin\Specification;

use App\Category;
use App\Specification;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateSpecificationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guest_cant_visit_create_specification_page()
    {
        $this->get(route('admin.specifications.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_specification_page()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();

        $this->actingAs($user)
            ->get(route('admin.specifications.create', ['category_id' => $category->id]))
            ->assertViewIs('admin.specifications.create');
    }

    /** @test */
    public function guest_cant_create_specification()
    {
        $stub = factory(Specification::class)->raw();

        $this->post(route('admin.specifications.store'), $stub)
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_specification()
    {
        $user = factory(User::class)->create();

        $stub = factory(Specification::class)->raw();

        $this->actingAs($user)
            ->post(route('admin.specifications.store'), $stub)
            ->assertRedirect(route('admin.categories.show', $stub['category_id']))
            ->assertSessionHas('status', trans('specification.created'));

        $specification = Specification::firstWhere($stub);

        $this->assertDatabaseHas('attribute_category', ['id' => $specification->id]);
    }

    /** @test */
    public function user_cant_create_specification_without_category()
    {
        $user = factory(User::class)->create();

        $stub = factory(Specification::class)->raw(['category_id' => null]);

        $this->actingAs($user)
            ->post(route('admin.specifications.store'), $stub)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_create_specification_with_string_category()
    {
        $user = factory(User::class)->create();

        $stub = factory(Specification::class)->raw(['category_id' => 'string']);

        $this->actingAs($user)
            ->post(route('admin.specifications.store'), $stub)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_create_specification_with_nonexistent_category()
    {
        $user = factory(User::class)->create();

        $stub = factory(Specification::class)->raw(['category_id' => 10]);

        $this->actingAs($user)
            ->post(route('admin.specifications.store'), $stub)
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_create_specification_without_attribute()
    {
        $user = factory(User::class)->create();

        $stub = factory(Specification::class)->raw(['attribute_id' => null]);

        $this->actingAs($user)
            ->post(route('admin.specifications.store'), $stub)
            ->assertSessionHasErrors('attribute_id');
    }

    /** @test */
    public function user_cant_create_specification_with_string_attribute()
    {
        $user = factory(User::class)->create();

        $stub = factory(Specification::class)->raw(['attribute_id' => 'string']);

        $this->actingAs($user)
            ->post(route('admin.specifications.store'), $stub)
            ->assertSessionHasErrors('attribute_id');
    }

    /** @test */
    public function user_cant_create_specification_with_nonexistent_attribute()
    {
        $user = factory(User::class)->create();

        $stub = factory(Specification::class)->raw(['attribute_id' => 10]);

        $this->actingAs($user)
            ->post(route('admin.specifications.store'), $stub)
            ->assertSessionHasErrors('attribute_id');
    }

    /** @test */
    public function user_cant_create_existing_specification()
    {
        $user = factory(User::class)->create();
        $specification = factory(Specification::class)->create();

        $this->actingAs($user)
            ->post(route('admin.specifications.store'), $specification->toArray())
            ->assertSessionHasErrors('attribute_id');
    }
}
