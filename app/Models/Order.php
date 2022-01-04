<?php

namespace App\Models;

use App\Enums\Status;
use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Casts\Attribute as AttributeCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 'status', 'total', 'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => Status::class,
    ];

    /**
     * Get the customer that owns the order.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * The products that belong to the order.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->using(Cart::class)
            ->withPivot('id', 'quantity')
            ->withTimestamps();
    }

    /**
     * Calculate and update order total.
     */
    public function updateTotal()
    {
        $this->update(['total' => $this->total()]);
    }

    /**
     * Get order total.
     *
     * @return int
     */
    public function total()
    {
        return $this->products->sum(fn ($product) => $product->uah_price * $product->pivot->quantity);
    }

    /**
     * Formatted total.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function decimalTotal(): AttributeCast
    {
        return new AttributeCast(
            fn () => number_format($this->total / 100, 2, '.', '')
        );
    }
}
