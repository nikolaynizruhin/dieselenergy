<?php

namespace Tests\Feature\Product;

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
        $diesel = factory(Product::class)->create(['name' => 'Diesel']);

        $this->get(route('products.index', ['search' => $diesel->name]))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_search_products()
    {
        $user = factory(User::class)->create();

        $diesel = factory(Product::class)->create(['name' => 'Diesel']);
        $patrol = factory(Product::class)->create(['name' => 'Patrol']);

        $this->actingAs($user)
            ->get(route('products.index', ['search' => $diesel->name]))
            ->assertSee($diesel->name)
            ->assertDontSee($patrol->name);
    }
}
