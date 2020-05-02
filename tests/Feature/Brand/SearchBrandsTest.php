<?php

namespace Tests\Feature\Brand;

use App\Brand;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchBrandsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_brands()
    {
        $brand = factory(Brand::class)->create();

        $this->get(route('brands.index', ['search' => $brand->name]))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_search_brands()
    {
        $user = factory(User::class)->create();

        $sdmo = factory(Brand::class)->create(['name' => 'SDMO']);
        $hyundai = factory(Brand::class)->create(['name' => 'Hyundai']);

        $this->actingAs($user)
            ->get(route('brands.index', ['search' => $sdmo->name]))
            ->assertSee($sdmo->name)
            ->assertDontSee($hyundai->name);
    }
}
