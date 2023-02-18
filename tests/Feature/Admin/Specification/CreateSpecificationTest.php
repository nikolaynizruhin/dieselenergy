<?php

namespace Tests\Feature\Admin\Specification;

use App\Models\Category;
use App\Models\Specification;
use Tests\TestCase;

class CreateSpecificationTest extends TestCase
{
    /** @test */
    public function guest_cant_visit_create_specification_page(): void
    {
        $this->get(route('admin.specifications.create'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_visit_create_specification_page(): void
    {
        $category = Category::factory()->create();

        $this->login()
            ->get(route('admin.specifications.create', ['category_id' => $category->id]))
            ->assertViewIs('admin.specifications.create');
    }

    /** @test */
    public function guest_cant_create_specification(): void
    {
        $this->post(route('admin.specifications.store'), self::validFields())
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_create_specification(): void
    {
        $this->login()
            ->post(route('admin.specifications.store'), $fields = self::validFields())
            ->assertRedirect(route('admin.categories.show', $fields['category_id']))
            ->assertSessionHas('status', trans('specification.created'));

        $this->assertDatabaseHas('attribute_category', $fields);
    }

    /**
     * @test
     *
     * @dataProvider validationProvider
     */
    public function user_cant_create_specification_with_invalid_data(string $field, callable $data, int $count = 0): void
    {
        $this->login()
            ->from(route('admin.specifications.create'))
            ->post(route('admin.specifications.store'), $data())
            ->assertRedirect(route('admin.specifications.create'))
            ->assertSessionHasErrors($field);

        $this->assertDatabaseCount('attribute_category', $count);
    }

    public static function validationProvider(): array
    {
        return [
            'Category is required' => [
                'category_id', fn () => self::validFields(['category_id' => null]),
            ],
            'Category cant be string' => [
                'category_id', fn () => self::validFields(['category_id' => 'string']),
            ],
            'Category must exists' => [
                'category_id', fn () => self::validFields(['category_id' => 10]),
            ],
            'Attribute is required' => [
                'attribute_id', fn () => self::validFields(['attribute_id' => null]),
            ],
            'Attribute cant be string' => [
                'attribute_id', fn () => self::validFields(['attribute_id' => 'string']),
            ],
            'Attribute must exists' => [
                'attribute_id', fn () => self::validFields(['attribute_id' => 10]),
            ],
            'Specification must be unique' => [
                'attribute_id', fn () => Specification::factory()->create()->toArray(), 1,
            ],
        ];
    }

    /**
     * Get valid specification fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private static function validFields(array $overrides = []): array
    {
        return Specification::factory()->raw($overrides);
    }
}
