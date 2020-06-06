<?php

namespace Tests\Feature\Admin\Product;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cant_search_products()
    {
        $product = factory(Product::class)->create();

        $this->get(route('admin.products.index', ['search' => $product->name]))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_search_products()
    {
        $user = factory(User::class)->create();

        $diesel = factory(Product::class)->create(['name' => 'Diesel']);
        $patrol = factory(Product::class)->create(['name' => 'Patrol']);

        $this->actingAs($user)
            ->get(route('admin.products.index', ['search' => $diesel->name]))
            ->assertSee($diesel->name)
            ->assertDontSee($patrol->name);
    }
}
