<?php

namespace Tests\Feature\Brand;

use App\Brand;
use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReadBrandsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_brands()
    {
        $this->get(route('brands.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_read_brands()
    {
        $user = factory(User::class)->create();

        [$sdmo, $hyundai] = factory(Brand::class, 2)->create();

        $this->actingAs($user)
            ->get(route('brands.index'))
            ->assertSuccessful()
            ->assertViewIs('brands.index')
            ->assertViewHas('brands')
            ->assertSee($sdmo->name)
            ->assertSee($hyundai->name);
    }
}
