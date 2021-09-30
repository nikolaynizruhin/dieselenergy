<?php

namespace Tests\Feature\Admin\Specification;

use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortSpecificationsTest extends TestCase
{


    /**
     * Height attribute.
     *
     * @var \App\Models\Attribute
     */
    private $height;

    /**
     * Width attribute.
     *
     * @var \App\Models\Attribute
     */
    private $width;

    /**
     * Category.
     *
     * @var \App\Models\Category
     */
    private $category;

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
    public function guest_cant_sort_specification()
    {
        $this->get(route('admin.categories.show', [
            'category' => $this->category,
            'search' => 'width',
        ]))->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_sort_specifications_ascending()
    {
        $this->login()
            ->get(route('admin.categories.show', [
                'category' => $this->category,
                'sort' => 'name',
            ]))->assertSuccessful()
            ->assertSeeInOrder([$this->height->name, $this->width->name]);
    }

    /** @test */
    public function user_can_sort_specifications_descending()
    {
        $this->login()
            ->get(route('admin.categories.show', [
                'category' => $this->category,
                'sort' => '-name',
            ]))->assertSuccessful()
            ->assertSeeInOrder([$this->width->name, $this->height->name]);
    }
}
