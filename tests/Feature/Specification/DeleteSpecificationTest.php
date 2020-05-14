<?php

namespace Tests\Feature\Specification;

use App\Attribute;
use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteSpecificationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_delete_category_attribute()
    {
        $attribute = factory(Attribute::class)->create();
        $category = factory(Category::class)->create();

        $category->attributes()->attach($attribute);

        $id = $category->attributes()->find($attribute->id)->pivot->id;

        $this->delete(route('specifications.destroy', $id))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_delete_category_attribute()
    {
        $user = factory(User::class)->create();

        $attribute = factory(Attribute::class)->create();
        $category = factory(Category::class)->create();

        $category->attributes()->attach($attribute);

        $id = $category->attributes()->find($attribute->id)->pivot->id;

        $this->actingAs($user)
            ->from(route('categories.show', $category))
            ->delete(route('specifications.destroy', $id))
            ->assertRedirect(route('categories.show', $category))
            ->assertSessionHas('status', 'Category attribute was detached successfully!');

        $this->assertDatabaseMissing('attributables', ['id' => $id]);
    }
}
