<?php

namespace Tests\Feature\Admin\Product;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_read_products()
    {
        $this->get(route('admin.products.index'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_products()
    {
        $user = factory(User::class)->create();

        [$petrol, $diesel] = factory(Product::class, 2)->create();

        $this->actingAs($user)
            ->get(route('admin.products.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.products.index')
            ->assertViewHas('products')
            ->assertSee($diesel->name)
            ->assertSee($petrol->name);
    }
}
