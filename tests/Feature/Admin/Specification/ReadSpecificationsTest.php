<?php

namespace Tests\Feature\Admin\Specification;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadSpecificationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_read_specifications()
    {


        [$width, $height] = Attribute::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'width attribute'],
                ['name' => 'height attribute'],
            ))->create();

        $category = Category::factory()->create();

        $category->attributes()->attach([$width->id, $height->id]);

        $this->login()
            ->get(route('admin.categories.show', $category))
            ->assertSuccessful()
            ->assertViewIs('admin.categories.show')
            ->assertViewHas('attributes')
            ->assertSeeInOrder([$height->name, $width->name]);
    }
}
