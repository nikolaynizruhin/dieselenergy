<?php

namespace Tests\Feature\Admin\Product;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_sort_products()
    {
        $this->get(route('admin.products.index', ['sort' => 'name']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_sort_products_by_name_ascending()
    {
        $user = User::factory()->create();

        [$patrol, $diesel] = Product::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Patrol Generator'],
                ['name' => 'Diesel Generator'],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.products.index', ['sort' => 'name']))
            ->assertSuccessful()
            ->assertViewIs('admin.products.index')
            ->assertViewHas('products')
            ->assertSeeInOrder([$diesel->name, $patrol->name]);
    }

    /** @test */
    public function admin_can_sort_products_by_name_descending()
    {
        $user = User::factory()->create();

        [$patrol, $diesel] = Product::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Patrol Generator'],
                ['name' => 'Diesel Generator'],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.products.index', ['sort' => '-name']))
            ->assertSuccessful()
            ->assertViewIs('admin.products.index')
            ->assertViewHas('products')
            ->assertSeeInOrder([$patrol->name, $diesel->name]);
    }

    /** @test */
    public function admin_can_sort_products_by_category_ascending()
    {
        $user = User::factory()->create();

        [$ats, $generators] = Category::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' =>'ATS'],
                ['name' =>'Generators'],
            ))->create();

        Product::factory()
            ->count(2)
            ->state(new Sequence(
                ['category_id' => $ats],
                ['category_id' => $generators],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.products.index', ['sort' => 'categories.name']))
            ->assertSuccessful()
            ->assertViewIs('admin.products.index')
            ->assertViewHas('products')
            ->assertSeeInOrder([$ats->name, $generators->name]);
    }

    /** @test */
    public function admin_can_sort_products_by_category_descending()
    {
        $user = User::factory()->create();

        [$ats, $generators] = Category::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' =>'ATS'],
                ['name' =>'Generators'],
            ))->create();

        Product::factory()
            ->count(2)
            ->state(new Sequence(
                ['category_id' => $ats],
                ['category_id' => $generators],
            ))->create();

        $this->actingAs($user)
            ->get(route('admin.products.index', ['sort' => '-categories.name']))
            ->assertSuccessful()
            ->assertViewIs('admin.products.index')
            ->assertViewHas('products')
            ->assertSeeInOrder([$generators->name, $ats->name]);
    }
}
