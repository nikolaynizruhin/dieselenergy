<?php

namespace Tests\Feature\Admin\Attribute;

use App\Models\Attribute;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchAttributesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_attributes()
    {
        $attribute = Attribute::factory()->create();

        $this->get(route('admin.attributes.index', ['search' => $attribute->name]))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_attributes()
    {
        $user = User::factory()->create();

        $power = Attribute::factory()->create(['name' => 'power']);
        $width = Attribute::factory()->create(['name' => 'width attribute']);
        $height = Attribute::factory()->create(['name' => 'height attribute']);

        $this->actingAs($user)
            ->get(route('admin.attributes.index', ['search' => 'attribute']))
            ->assertSeeInOrder([$height->name, $width->name])
            ->assertDontSee($power->name);
    }
}
