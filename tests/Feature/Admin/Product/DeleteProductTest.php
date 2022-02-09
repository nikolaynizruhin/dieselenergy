<?php

namespace Tests\Feature\Admin\Product;

use App\Models\Product;
use Tests\TestCase;

class DeleteProductTest extends TestCase
{
    /**
     * Product.
     *
     * @var \App\Models\Product
     */
    private $product;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->product = Product::factory()->create();
    }

    /** @test */
    public function guest_cant_delete_product()
    {
        $this->delete(route('admin.products.destroy', $this->product))
            ->assertRedirect(route('admin.login'));
    }

    /** @test */
    public function user_can_delete_product()
    {
        $this->login()
            ->from(route('admin.products.index'))
            ->delete(route('admin.products.destroy', $this->product))
            ->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('status', trans('product.deleted'));

        $this->assertModelMissing($this->product);
    }
}
