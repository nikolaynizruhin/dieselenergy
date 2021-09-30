<?php

namespace Tests\Feature\Admin\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortProductsTest extends TestCase
{


    /** @test */
    public function guest_cant_sort_products()
    {
        $this->get(route('admin.products.index', ['sort' => 'name']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_sort_products_by_name_ascending()
    {
        [$patrol, $diesel] = Product::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Patrol Generator'],
                ['name' => 'Diesel Generator'],
            ))->create();

        $this->login()
            ->get(route('admin.products.index', ['sort' => 'name']))
            ->assertSuccessful()
            ->assertViewIs('admin.products.index')
            ->assertViewHas('products')
            ->assertSeeInOrder([$diesel->name, $patrol->name]);
    }

    /** @test */
    public function admin_can_sort_products_by_name_descending()
    {
        [$patrol, $diesel] = Product::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Patrol Generator'],
                ['name' => 'Diesel Generator'],
            ))->create();

        $this->login()
            ->get(route('admin.products.index', ['sort' => '-name']))
            ->assertSuccessful()
            ->assertViewIs('admin.products.index')
            ->assertViewHas('products')
            ->assertSeeInOrder([$patrol->name, $diesel->name]);
    }

    /** @test */
    public function admin_can_sort_products_by_price_ascending()
    {
        [$patrol, $diesel] = Product::factory()
            ->count(2)
            ->state(new Sequence(
                ['price' => 200],
                ['price' => 100],
            ))->create();

        $this->login()
            ->get(route('admin.products.index', ['sort' => 'price']))
            ->assertSuccessful()
            ->assertViewIs('admin.products.index')
            ->assertViewHas('products')
            ->assertSeeInOrder([$diesel->name, $patrol->name]);
    }

    /** @test */
    public function admin_can_sort_products_by_price_descending()
    {
        [$patrol, $diesel] = Product::factory()
            ->count(2)
            ->state(new Sequence(
                ['price' => 200],
                ['price' => 100],
            ))->create();

        $this->login()
            ->get(route('admin.products.index', ['sort' => '-price']))
            ->assertSuccessful()
            ->assertViewIs('admin.products.index')
            ->assertViewHas('products')
            ->assertSeeInOrder([$patrol->name, $diesel->name]);
    }

    /** @test */
    public function admin_can_sort_products_by_status_ascending()
    {
        [$patrol, $diesel] = Product::factory()
            ->count(2)
            ->state(new Sequence(
                ['is_active' => true],
                ['is_active' => false],
            ))->create();

        $this->login()
            ->get(route('admin.products.index', ['sort' => 'is_active']))
            ->assertSuccessful()
            ->assertViewIs('admin.products.index')
            ->assertViewHas('products')
            ->assertSeeInOrder([$diesel->name, $patrol->name]);
    }

    /** @test */
    public function admin_can_sort_products_by_status_descending()
    {
        [$patrol, $diesel] = Product::factory()
            ->count(2)
            ->state(new Sequence(
                ['is_active' => true],
                ['is_active' => false],
            ))->create();

        $this->login()
            ->get(route('admin.products.index', ['sort' => '-is_active']))
            ->assertSuccessful()
            ->assertViewIs('admin.products.index')
            ->assertViewHas('products')
            ->assertSeeInOrder([$patrol->name, $diesel->name]);
    }

    /** @test */
    public function admin_can_sort_products_by_category_ascending()
    {
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

        $this->login()
            ->get(route('admin.products.index', ['sort' => 'categories.name']))
            ->assertSuccessful()
            ->assertViewIs('admin.products.index')
            ->assertViewHas('products')
            ->assertSeeInOrder([$ats->name, $generators->name]);
    }

    /** @test */
    public function admin_can_sort_products_by_category_descending()
    {
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

        $this->login()
            ->get(route('admin.products.index', ['sort' => '-categories.name']))
            ->assertSuccessful()
            ->assertViewIs('admin.products.index')
            ->assertViewHas('products')
            ->assertSeeInOrder([$generators->name, $ats->name]);
    }
}
