<?php

namespace Tests\Feature\Admin\Specification;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadSpecificationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_read_specifications()
    {
        $user = User::factory()->create();

        $width = Attribute::factory()->create(['name' => 'width attribute']);
        $height = Attribute::factory()->create(['name' => 'height attribute']);

        $category = Category::factory()->create();

        $category->attributes()->attach([$width->id, $height->id]);

        $this->actingAs($user)
            ->get(route('admin.categories.show', $category))
            ->assertSuccessful()
            ->assertViewIs('admin.categories.show')
            ->assertViewHas('attributes')
            ->assertSeeInOrder([$height->name, $width->name]);
    }
}
