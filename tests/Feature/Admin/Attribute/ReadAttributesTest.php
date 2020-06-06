<?php

namespace Tests\Feature\Admin\Attribute;

use App\Attribute;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadAttributesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_attributes()
    {
        $this->get(route('admin.attributes.index'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_attributes()
    {
        $user = factory(User::class)->create();

        $weight = factory(Attribute::class)->create(['name' => 'Weight']);
        $power = factory(Attribute::class)->create(['name' => 'Power']);

        $this->actingAs($user)
            ->get(route('admin.attributes.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.attributes.index')
            ->assertViewHas('attributes')
            ->assertSeeInOrder([$power->name, $weight->name]);
    }
}
