<?php

namespace Tests\Feature\Admin\Specification;

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
        $weight = factory(Attribute::class)->create(['name' => 'weight property']);

        $category = factory(Category::class)->create();

        $category->attributes()->attach([$width->id, $height->id, $weight->id]);

        $this->actingAs($user)
            ->get(route('admin.categories.show', [
                'category' => $category,
                'search' => 'attribute',
            ]))->assertSuccessful()
            ->assertSeeInOrder([$height->name, $width->name])
            ->assertDontSee($weight->name);
    }
}
