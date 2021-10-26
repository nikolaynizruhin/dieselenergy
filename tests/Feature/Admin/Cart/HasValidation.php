<?php

namespace Tests\Feature\Admin\Cart;

use App\Models\Brand;
use App\Models\Cart;
use Illuminate\Support\Str;

trait HasValidation
{
    public function provider($count = 1): array
    {
        return [
            'Quantity is required' => [
                'quantity', fn () => $this->validFields(['quantity' => null]),
            ],
            'Quantity cant be a string' => [
                'quantity', fn () => $this->validFields(['quantity' => 'string']),
            ],
            'Quantity cant be zero' => [
                'quantity', fn () => $this->validFields(['quantity' => 0]),
            ],
            'Product is required' => [
                'product_id', fn () => $this->validFields(['product_id' => null]),
            ],
            'Product cant be string' => [
                'product_id', fn () => $this->validFields(['product_id' => 'string']),
            ],
            'Product must exists' => [
                'product_id', fn () => $this->validFields(['product_id' => 10]),
            ],
            'Order is required' => [
                'order_id', fn () => $this->validFields(['order_id' => null]),
            ],
            'Order cant be string' => [
                'order_id', fn () => $this->validFields(['order_id' => 'string']),
            ],
            'Order must exists' => [
                'order_id', fn () => $this->validFields(['order_id' => 10]),
            ],
            'Cart must be unique' => [
                'product_id', fn () => Cart::factory()->create()->toArray(), $count,
            ],
        ];
    }

    /**
     * Get valid cart fields.
     *
     * @param  array  $overrides
     * @return array
     */
    private function validFields($overrides = [])
    {
        return Cart::factory()->raw($overrides);
    }
}
