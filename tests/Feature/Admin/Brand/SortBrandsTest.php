<?php

namespace Tests\Feature\Admin\Brand;

use App\Models\Brand;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class SortBrandsTest extends TestCase
{
    /** @test */
    public function guest_cant_sort_brands(): void
    {
        $this->get(route('admin.brands.index', ['sort' => 'name']))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function admin_can_sort_brands_by_name_ascending(): void
    {
        [$hyundai, $sdmo] = Brand::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Hyundai'],
                ['name' => 'SDMO'],
            ))->create();

        $this->login()
            ->get(route('admin.brands.index', ['sort' => 'name']))
            ->assertSuccessful()
            ->assertViewIs('admin.brands.index')
            ->assertViewHas('brands')
            ->assertSeeInOrder([$hyundai->name, $sdmo->name]);
    }

    /** @test */
    public function admin_can_sort_brands_by_name_descending(): void
    {
        [$hyundai, $sdmo] = Brand::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Hyundai'],
                ['name' => 'SDMO'],
            ))->create();

        $this->login()
            ->get(route('admin.brands.index', ['sort' => '-name']))
            ->assertSuccessful()
            ->assertViewIs('admin.brands.index')
            ->assertViewHas('brands')
            ->assertSeeInOrder([$sdmo->name, $hyundai->name]);
    }

    /** @test */
    public function admin_can_sort_brands_by_currency_ascending(): void
    {
        [$usd, $eur] = Currency::factory()
            ->count(2)
            ->state(new Sequence(
                ['code' => 'USD'],
                ['code' => 'EUR'],
            ))->create();

        Brand::factory()
            ->count(2)
            ->state(new Sequence(
                ['currency_id' => $usd],
                ['currency_id' => $eur],
            ))->create();

        $this->login()
            ->get(route('admin.brands.index', ['sort' => 'currencies.code']))
            ->assertSuccessful()
            ->assertViewIs('admin.brands.index')
            ->assertViewHas('brands')
            ->assertSeeInOrder([$eur->code, $usd->code]);
    }

    /** @test */
    public function admin_can_sort_brands_by_currency_descending(): void
    {
        [$usd, $eur] = Currency::factory()
            ->count(2)
            ->state(new Sequence(
                ['code' => 'USD'],
                ['code' => 'EUR'],
            ))->create();

        Brand::factory()
            ->count(2)
            ->state(new Sequence(
                ['currency_id' => $usd],
                ['currency_id' => $eur],
            ))->create();

        $this->login()
            ->get(route('admin.brands.index', ['sort' => 'currencies.code']))
            ->assertSuccessful()
            ->assertViewIs('admin.brands.index')
            ->assertViewHas('brands')
            ->assertSeeInOrder([$eur->code, $usd->code]);
    }
}
