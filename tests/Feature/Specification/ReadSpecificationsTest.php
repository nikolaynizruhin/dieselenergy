<?php

namespace Tests\Feature\Specification;

use App\Attribute;
use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadSpecificationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_read_category_attributes()
    {
        $user = factory(User::class)->create();

        $attribute = factory(Attribute::class)->create();
        $category = factory(Category::class)->create();

        $category->attributes()->attach($attribute);

        $this->actingAs($user)
            ->get(route('categories.show', $category))
            ->assertSuccessful()
            ->assertViewIs('categories.show')
            ->assertViewHas('attributes')
            ->assertSee($attribute->name);
    }
}
