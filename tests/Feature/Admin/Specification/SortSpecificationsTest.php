<?php

namespace Tests\Feature\Admin\Specification;

use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class SortSpecificationsTest extends TestCase
{
    /**
     * Height attribute.
     */
    private Attribute $height;

    /**
     * Width attribute.
     */
    private Attribute $width;

    /**
     * Category.
     */
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        [$this->height, $this->width] = Attribute::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'height attribute'],
                ['name' => 'width attribute'],
            ))->create();

        $this->category = Category::factory()->create();

        $this->category->attributes()->attach([$this->width->id, $this->height->id]);
    }

    /** @test */
    public function guest_cant_sort_specification(): void
    {
        $this->get(route('admin.categories.show', [
            'category' => $this->category,
            'search' => 'width',
        ]))->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_sort_specifications_ascending(): void
    {
        $this->login()
            ->get(route('admin.categories.show', [
                'category' => $this->category,
                'sort' => 'name',
            ]))->assertSuccessful()
            ->assertSeeInOrder([$this->height->name, $this->width->name]);
    }

    /** @test */
    public function user_can_sort_specifications_descending(): void
    {
        $this->login()
            ->get(route('admin.categories.show', [
                'category' => $this->category,
                'sort' => '-name',
            ]))->assertSuccessful()
            ->assertSeeInOrder([$this->width->name, $this->height->name]);
    }
}
