<?php

namespace Tests\Feature\Admin\Specification;

use App\Attribute;
use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadSpecificationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_read_specifications()
    {
        $user = factory(User::class)->create();

        $width = factory(Attribute::class)->create(['name' => 'width attribute']);
        $height = factory(Attribute::class)->create(['name' => 'height attribute']);

        $category = factory(Category::class)->create();

        $category->attributes()->attach([$width->id, $height->id]);

        $this->actingAs($user)
            ->get(route('admin.categories.show', $category))
            ->assertSuccessful()
            ->assertViewIs('admin.categories.show')
            ->assertViewHas('attributes')
            ->assertSeeInOrder([$height->name, $width->name]);
    }
}
