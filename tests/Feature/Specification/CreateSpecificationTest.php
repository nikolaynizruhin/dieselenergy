<?php

namespace Tests\Feature\Specification;

use App\Attribute;
use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateSpecificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_visit_create_specification_page()
    {
        $this->get(route('specifications.create'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_visit_create_specification_page()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();

        $this->actingAs($user)
            ->get(route('specifications.create', ['category_id' => $category->id]))
            ->assertViewIs('specifications.create');
    }

    /** @test */
    public function guest_cant_create_specification()
    {
        $category = factory(Category::class)->create();
        $attribute = factory(Attribute::class)->create();

        $this->post(route('specifications.store'), [
            'category_id' => $category->id,
            'attribute_id' => $attribute->id,
        ])->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_create_specification()
    {
        $user = factory(User::class)->create();

        $category = factory(Category::class)->create();
        $attribute = factory(Attribute::class)->create();

        $this->actingAs($user)
            ->post(route('specifications.store'), [
                'category_id' => $category->id,
                'attribute_id' => $attribute->id,
            ])->assertRedirect(route('categories.show', $category))
            ->assertSessionHas('status', 'Attribute was attached successfully!');

        $id = $category->fresh()->attributes()->find($attribute->id)->pivot->id;

        $this->assertDatabaseHas('attributables', ['id' => $id]);
    }

    /** @test */
    public function user_cant_create_specification_without_category()
    {
        $user = factory(User::class)->create();

        $attribute = factory(Attribute::class)->create();

        $this->actingAs($user)
            ->post(route('specifications.store'), [
                'attribute_id' => $attribute->id,
            ])->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_create_specification_with_string_category()
    {
        $user = factory(User::class)->create();

        $attribute = factory(Attribute::class)->create();

        $this->actingAs($user)
            ->post(route('specifications.store'), [
                'category_id' => 'string',
                'attribute_id' => $attribute->id,
            ])->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_create_specification_with_nonexistent_category()
    {
        $user = factory(User::class)->create();

        $attribute = factory(Attribute::class)->create();

        $this->actingAs($user)
            ->post(route('specifications.store'), [
                'category_id' => 1,
                'attribute_id' => $attribute->id,
            ])->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function user_cant_create_specification_without_attribute()
    {
        $user = factory(User::class)->create();

        $category = factory(Category::class)->create();

        $this->actingAs($user)
            ->post(route('specifications.store'), [
                'category_id' => $category->id,
            ])->assertSessionHasErrors('attribute_id');
    }

    /** @test */
    public function user_cant_create_specification_with_string_attribute()
    {
        $user = factory(User::class)->create();

        $category = factory(Category::class)->create();

        $this->actingAs($user)
            ->post(route('specifications.store'), [
                'category_id' => $category->id,
                'attribute_id' => 'string',
            ])->assertSessionHasErrors('attribute_id');
    }

    /** @test */
    public function user_cant_create_specification_with_nonexistent_attribute()
    {
        $user = factory(User::class)->create();

        $category = factory(Category::class)->create();

        $this->actingAs($user)
            ->post(route('specifications.store'), [
                'category_id' => $category->id,
                'attribute_id' => 1,
            ])->assertSessionHasErrors('attribute_id');
    }

    /** @test */
    public function user_cant_create_existing_specification()
    {
        $user = factory(User::class)->create();

        $category = factory(Category::class)->create();
        $attribute = factory(Attribute::class)->create();

        $category->attributes()->attach($attribute);

        $this->actingAs($user)
            ->post(route('specifications.store'), [
                'category_id' => $category->id,
                'attribute_id' => $attribute->id,
            ])->assertSessionHasErrors('attribute_id');
    }
}
