<?php

namespace Tests\Feature\Admin\Brand;

use App\Brand;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadBrandsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_brands()
    {
        $this->get(route('admin.brands.index'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_brands()
    {
        $user = factory(User::class)->create();

        $sdmo = factory(Brand::class)->create(['name' => 'SDMO']);
        $hyundai = factory(Brand::class)->create(['name' => 'Hyundai']);

        $this->actingAs($user)
            ->get(route('admin.brands.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.brands.index')
            ->assertViewHas('brands')
            ->assertSeeInOrder([$hyundai->name, $sdmo->name]);
    }
}
