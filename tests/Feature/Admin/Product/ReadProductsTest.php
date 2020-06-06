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

        $petrol = factory(Product::class)->create(['name' => 'Petrol']);
        $diesel = factory(Product::class)->create(['name' => 'Diesel']);

        $this->actingAs($user)
            ->get(route('admin.products.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.products.index')
            ->assertViewHas('products')
            ->assertSeeInOrder([$diesel->name, $petrol->name]);
    }
}
