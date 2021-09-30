<?php

namespace Tests\Feature\Admin\Attribute;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchAttributesTest extends TestCase
{


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
        [$power, $width, $height] = Attribute::factory()
            ->count(3)
            ->state(new Sequence(
                ['name' => 'power'],
                ['name' => 'width attribute'],
                ['name' => 'height attribute'],
            ))->create();

        $this->login()
            ->get(route('admin.attributes.index', ['search' => 'attribute']))
            ->assertSeeInOrder([$height->name, $width->name])
            ->assertDontSee($power->name);
    }
}
