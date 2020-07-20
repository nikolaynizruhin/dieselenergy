<?php

namespace Tests\Feature\Admin\Specification;

use App\Attribute;
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
        $category = factory(Category::class)->create();
        $attribute = factory(Attribute::class)->create();

        $this->post(route('admin.specifications.store'), [
            'category_id' => $category->id,
            'attribute_id' => $attribute->id,
            'is_featured' => $this->faker->boolean,
        ])->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_specification()
    {
        $user = factory(User::class)->create();

        $category = factory(Category::class)->create();
        $attribute = factory(Attribute::class)->create();

        $this->actingAs($user)
            ->post(route('admin.specifications.store'), [
                'category_id' => $category->id,
                'attribute_id' => $attribute->id,
                'is_featured' => $isFeatured = $this->faker->boolean,
            ])->assertRedirect(route('admin.categories.show', $category))
            ->assertSessionHas('status', trans('specification.created'));

        $specification = Specification::firstWhere([
            'attributable_id' => $category->id,
            'attributable_type' => Category::class,
            'attribute_id' => $attribute->id,
            'is_featured' => $isFeatured,
        ]);

        $this->assertDatabaseHas('attributables', ['id' => $specification->id]);
    }

    /** @test */
    public function user_cant_create_specification_without_category()
    {
        $user = factory(User::class)->create();

        $attribute = factory(Attribute::class)->create();

        $this->actingAs($user)
            ->post(route('admin.specifications.store'), [
                'attribute_id' => $attribute->id,
                'is_featured' => $this->faker->boolean,
            ])->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_create_specification_with_string_category()
    {
        $user = factory(User::class)->create();

        $attribute = factory(Attribute::class)->create();

        $this->actingAs($user)
            ->post(route('admin.specifications.store'), [
                'category_id' => 'string',
                'attribute_id' => $attribute->id,
                'is_featured' => $this->faker->boolean,
            ])->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_create_specification_with_nonexistent_category()
    {
        $user = factory(User::class)->create();

        $attribute = factory(Attribute::class)->create();

        $this->actingAs($user)
            ->post(route('admin.specifications.store'), [
                'category_id' => 1,
                'attribute_id' => $attribute->id,
                'is_featured' => $this->faker->boolean,
            ])->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_create_specification_without_attribute()
    {
        $user = factory(User::class)->create();

        $category = factory(Category::class)->create();

        $this->actingAs($user)
            ->post(route('admin.specifications.store'), [
                'category_id' => $category->id,
                'is_featured' => $this->faker->boolean,
            ])->assertSessionHasErrors('attribute_id');
    }

    /** @test */
    public function user_cant_create_specification_with_string_attribute()
    {
        $user = factory(User::class)->create();

        $category = factory(Category::class)->create();

        $this->actingAs($user)
            ->post(route('admin.specifications.store'), [
                'category_id' => $category->id,
                'attribute_id' => 'string',
                'is_featured' => $this->faker->boolean,
            ])->assertSessionHasErrors('attribute_id');
    }

    /** @test */
    public function user_cant_create_specification_with_nonexistent_attribute()
    {
        $user = factory(User::class)->create();

        $category = factory(Category::class)->create();

        $this->actingAs($user)
            ->post(route('admin.specifications.store'), [
                'category_id' => $category->id,
                'attribute_id' => 1,
                'is_featured' => $this->faker->boolean,
            ])->assertSessionHasErrors('attribute_id');
    }

    /** @test */
    public function user_cant_create_existing_specification()
    {
        $user = factory(User::class)->create();
        $specification = factory(Specification::class)->create();

        $this->actingAs($user)
            ->post(route('admin.specifications.store'), [
                'category_id' => $specification->attributable_id,
                'attribute_id' => $specification->attribute_id,
                'is_featured' => $specification->is_featured,
            ])->assertSessionHasErrors('attribute_id');
    }
}
