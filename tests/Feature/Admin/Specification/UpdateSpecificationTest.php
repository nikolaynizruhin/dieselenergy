<?php

namespace Tests\Feature\Admin\Specification;

use App\Models\Specification;
use Tests\TestCase;

class UpdateSpecificationTest extends TestCase
{
    /**
     * Product.
     *
     * @var \App\Models\Specification
     */
    private $specification;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->specification = Specification::factory()->create();
    }

    /** @test */
    public function guest_cant_visit_update_specification_page()
    {
        $this->get(route('admin.specifications.edit', $this->specification))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_update_specification_page()
    {
        $this->login()
            ->get(route('admin.specifications.edit', $this->specification))
            ->assertViewIs('admin.specifications.edit');
    }

    /** @test */
    public function guest_cant_update_specification()
    {
        $this->put(route('admin.specifications.update', $this->specification))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_update_specification()
    {
        $this->login()
            ->put(route('admin.specifications.update', $this->specification), $fields = $this->validFields())
            ->assertRedirect(route('admin.categories.show', $fields['category_id']))
            ->assertSessionHas('status', trans('specification.updated'));

        $this->assertDatabaseHas('attribute_category', $fields);
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function user_cant_update_specification_with_invalid_data($field, $data, $count = 1)
    {
        $this->login()
            ->from(route('admin.specifications.edit', $this->specification))
            ->put(route('admin.specifications.update', $this->specification), $data())
            ->assertRedirect(route('admin.specifications.edit', $this->specification))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('attribute_category', $count);
    }

    public function validationProvider(): array
    {
        return [
            'Category is required' => [
                'category_id', fn () => $this->validFields(['category_id' => null]),
            ],
            'Category cant be string' => [
                'category_id', fn () => $this->validFields(['category_id' => 'string']),
            ],
            'Category must exists' => [
                'category_id', fn () => $this->validFields(['category_id' => 10]),
            ],
            'Attribute is required' => [
                'attribute_id', fn () => $this->validFields(['attribute_id' => null]),
            ],
            'Attribute cant be string' => [
                'attribute_id', fn () => $this->validFields(['attribute_id' => 'string']),
            ],
            'Attribute must exists' => [
                'attribute_id', fn () => $this->validFields(['attribute_id' => 10]),
            ],
            'Specification must be unique' => [
                'attribute_id', fn () => Specification::factory()->create()->toArray(), 2,
            ],
        ];
    }

    /**
     * Get valid specification fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields($overrides = [])
    {
        return Specification::factory()->raw($overrides);
    }
}
