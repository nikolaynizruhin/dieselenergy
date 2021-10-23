<?php

namespace Tests\Feature\Admin\Attribute;

use App\Models\Attribute;
use Illuminate\Support\Str;
use Tests\TestCase;

class CreateAttributeTest extends TestCase
{
    /** @test */
    public function guest_cant_visit_create_attribute_page()
    {
        $this->get(route('admin.attributes.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_attribute_page()
    {
        $this->login()
            ->get(route('admin.attributes.create'))
            ->assertViewIs('admin.attributes.create');
    }

    /** @test */
    public function guest_cant_create_attribute()
    {
        $this->post(route('admin.attributes.store'), $this->validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_attribute()
    {
        $this->login()
            ->post(route('admin.attributes.store'), $fields = $this->validFields())
            ->assertRedirect(route('admin.attributes.index'))
            ->assertSessionHas('status', trans('attribute.created'));

        $this->assertDatabaseHas('attributes', $fields);
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_create_attribute_with_invalid_data($field, $data, $count = 0)
    {
        $this->login()
            ->from(route('admin.attributes.create'))
            ->post(route('admin.attributes.store'), $data())
            ->assertRedirect(route('admin.attributes.create'))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('attributes', $count);
    }

    public function validationProvider(): array
    {
        return [
            'Name is required' => [
                'name', fn () => $this->validFields(['name' => null]),
            ],
            'Name cant be an integer' => [
                'name', fn () => $this->validFields(['name' => 1]),
            ],
            'Name cant be more than 255 chars' => [
                'name', fn () => $this->validFields(['name' => Str::random(256)]),
            ],
            'Measure cant be an integer' => [
                'measure', fn () => $this->validFields(['measure' => 1]),
            ],
            'Measure cant be more than 255 chars' => [
                'measure', fn () => $this->validFields(['measure' => Str::random(256)]),
            ],
            'Name must be unique' => [
                'name', fn () => $this->validFields(['name' => Attribute::factory()->create()->name]), 1,
            ],
        ];
    }

    /**
     * Get valid contact fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields($overrides = [])
    {
        return Attribute::factory()->raw($overrides);
    }
}
