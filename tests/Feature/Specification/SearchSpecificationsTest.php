<?php

namespace Tests\Feature\Specification;

use App\Attribute;
use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchSpecificationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_search_specifications()
    {
        $user = factory(User::class)->create();

        $width = factory(Attribute::class)->create(['name' => 'width attribute']);
        $height = factory(Attribute::class)->create(['name' => 'height attribute']);

        $category = factory(Category::class)->create();

        $category->attributes()->attach([$width->id, $height->id]);

        $this->actingAs($user)
            ->get(route('categories.show', [
                'category' => $category->id,
                'search' => $width->name,
            ]))->assertSuccessful()
            ->assertSee($width->name)
            ->assertDontSee($height->name);
    }
}
