<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Filters\Filterable;
use App\Support\Money;
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
        'status' => OrderStatus::class,
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
        $this->update(['total' => $this->getTotal()]);
    }

    /**
     * Get order total.
     *
     * @return int
     */
    public function getTotal()
    {
        return $this->products->sum(fn ($product) => $product->price->toUAH()->coins() * $product->pivot->quantity);
    }

    /**
     * Total price.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function total(): AttributeCast
    {
        return new AttributeCast(fn ($value) => new Money($value));
    }
}
