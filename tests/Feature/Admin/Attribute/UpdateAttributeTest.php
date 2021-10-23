<?php

namespace Tests\Feature\Admin\Attribute;

use App\Models\Attribute;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class UpdateAttributeTest extends TestCase
{
    use WithFaker;

    /**
     * Product.
     *
     * @var \App\Models\Attribute
     */
    private $attribute;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->attribute = Attribute::factory()->create();
    }

    /** @test */
    public function guest_cant_visit_update_attribute_page()
    {
        $this->get(route('admin.attributes.edit', $this->attribute))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_attribute_page()
    {
        $this->login()
            ->get(route('admin.attributes.edit', $this->attribute))
            ->assertViewIs('admin.attributes.edit')
            ->assertViewHas('attribute', $this->attribute);
    }

    /** @test */
    public function guest_cant_update_attribute()
    {
        $this->put(route('admin.attributes.update', $this->attribute), $this->validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_attribute()
    {
        $this->login()
            ->put(route('admin.attributes.update', $this->attribute), $fields = $this->validFields())
            ->assertRedirect(route('admin.attributes.index'))
            ->assertSessionHas('status', trans('attribute.updated'));

        $this->assertDatabaseHas('attributes', $fields);
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_update_attribute_with_invalid_data($field, $data, $count = 1)
    {
        $this->login()
            ->from(route('admin.attributes.edit', $this->attribute))
            ->put(route('admin.attributes.update', $this->attribute), $data())
            ->assertRedirect(route('admin.attributes.edit', $this->attribute))
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
                'name', fn () => $this->validFields(['name' => Attribute::factory()->create()->name]), 2,
            ]
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
