<?php

namespace Tests\Feature\Attribute;

use App\Attribute;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchAttributesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_attributes()
    {
        $attribute = factory(Attribute::class)->create();

        $this->get(route('attributes.index', ['search' => $attribute->name]))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_search_attributes()
    {
        $user = factory(User::class)->create();

        $power = factory(Attribute::class)->create(['name' => 'power']);
        $battery = factory(Attribute::class)->create(['name' => 'battery']);

        $this->actingAs($user)
            ->get(route('attributes.index', ['search' => $power->name]))
            ->assertSee($power->name)
            ->assertDontSee($battery->name);
    }
}
