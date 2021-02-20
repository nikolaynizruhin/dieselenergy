<?php

namespace Tests\Feature\Admin\Attribute;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Sequence;
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
        [$weight, $power] = Attribute::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Weight'],
                ['name' => 'Power'],
            ))->create();

        $this->login()
            ->get(route('admin.attributes.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.attributes.index')
            ->assertViewHas('attributes')
            ->assertSeeInOrder([$power->name, $weight->name]);
    }
}
