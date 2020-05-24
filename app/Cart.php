<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Cart extends Pivot
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_product';

    /**
     * Get the order that owns the cart.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product that owns the cart.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
