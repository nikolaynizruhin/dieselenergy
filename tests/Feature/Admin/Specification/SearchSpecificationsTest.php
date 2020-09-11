<?php

namespace Tests\Feature\Admin\Specification;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchSpecificationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_search_specifications()
    {
        $user = User::factory()->create();

        $width = Attribute::factory()->create(['name' => 'width attribute']);
        $height = Attribute::factory()->create(['name' => 'height attribute']);
        $weight = Attribute::factory()->create(['name' => 'weight property']);

        $category = Category::factory()->create();

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
