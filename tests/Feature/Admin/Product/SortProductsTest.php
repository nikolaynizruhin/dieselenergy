<?php

namespace Tests\Feature\Admin\Product;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Patrol generator.
     *
     * @var \App\Models\Product
     */
    private $patrol;

    /**
     * Diesel generator.
     *
     * @var \App\Models\Product
     */
    private $diesel;

    protected function setUp(): void
    {
        parent::setUp();

        [$this->patrol, $this->diesel] = Product::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Patrol Generator'],
                ['name' => 'Diesel Generator'],
            ))->create();
    }

    /** @test */
    public function guest_cant_sort_products()
    {
        $this->get(route('admin.products.index', ['sort' => 'name']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_sort_products_ascending()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.products.index', ['sort' => 'name']))
            ->assertSuccessful()
            ->assertViewIs('admin.products.index')
            ->assertViewHas('products')
            ->assertSeeInOrder([$this->diesel->name, $this->patrol->name]);
    }

    /** @test */
    public function admin_can_sort_products_descending()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.products.index', ['sort' => '-name']))
            ->assertSuccessful()
            ->assertViewIs('admin.products.index')
            ->assertViewHas('products')
            ->assertSeeInOrder([$this->patrol->name, $this->diesel->name]);
    }
}
