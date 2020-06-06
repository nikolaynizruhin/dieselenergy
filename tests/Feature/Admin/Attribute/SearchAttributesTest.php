<?php

namespace Tests\Feature\Admin\Attribute;

use App\Attribute;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchAttributesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_attributes()
    {
        $attribute = factory(Attribute::class)->create();

        $this->get(route('admin.attributes.index', ['search' => $attribute->name]))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_attributes()
    {
        $user = factory(User::class)->create();

        $power = factory(Attribute::class)->create(['name' => 'power']);
        $width = factory(Attribute::class)->create(['name' => 'width attribute']);
        $height = factory(Attribute::class)->create(['name' => 'height attribute']);

        $this->actingAs($user)
            ->get(route('admin.attributes.index', ['search' => 'attribute']))
            ->assertSeeInOrder([$height->name, $width->name])
            ->assertDontSee($power->name);
    }
}
