<?php

namespace Tests\Feature\Admin\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class ReadProductsTest extends TestCase
{
    /** @test */
    public function guest_cant_read_products()
    {
        $this->get(route('admin.products.index'))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_read_products()
    {
        [$petrol, $diesel] = Product::factory()
            ->count(2)
            ->state(new Sequence(
                ['name' => 'Petrol'],
                ['name' => 'Diesel'],
            ))->create();

        $this->login()
            ->get(route('admin.products.index'))
            ->assertSuccessful()
            ->assertViewIs('admin.products.index')
            ->assertViewHas('products')
            ->assertSeeInOrder([$diesel->name, $petrol->name]);
    }
}
