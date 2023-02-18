<?php

namespace Tests\Feature\Admin\Attribute;

use App\Models\Attribute;
use Tests\TestCase;

class UpdateAttributeTest extends TestCase
{
    use HasValidation;

    /**
     * Attribute.
     */
    private Attribute $attribute;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->attribute = Attribute::factory()->create();
    }

    /** @test */
    public function guest_cant_visit_update_attribute_page(): void
    {
        $this->get(route('admin.attributes.edit', $this->attribute))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_attribute_page(): void
    {
        $this->login()
            ->get(route('admin.attributes.edit', $this->attribute))
            ->assertViewIs('admin.attributes.edit')
            ->assertViewHas('attribute', $this->attribute);
    }

    /** @test */
    public function guest_cant_update_attribute(): void
    {
        $this->put(route('admin.attributes.update', $this->attribute), self::validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_attribute(): void
    {
        $this->login()
            ->put(route('admin.attributes.update', $this->attribute), $fields = self::validFields())
            ->assertRedirect(route('admin.attributes.index'))
            ->assertSessionHas('status', trans('attribute.updated'));

        $this->assertDatabaseHas('attributes', $fields);
    }

    /**
     * @test
     *
     * @dataProvider validationProvider
     */
    public function user_cant_update_attribute_with_invalid_data(string $field, callable $data, int $count = 1): void
    {
        $this->login()
            ->from(route('admin.attributes.edit', $this->attribute))
            ->put(route('admin.attributes.update', $this->attribute), $data())
            ->assertRedirect(route('admin.attributes.edit', $this->attribute))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('attributes', $count);
    }

    public static function validationProvider(): array
    {
        return self::provider(2);
    }
}
