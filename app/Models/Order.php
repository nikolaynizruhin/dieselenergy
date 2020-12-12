<?php

namespace App\Models;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, Filterable;

    /**
     * The new order status.
     *
     * @var string
     */
    const NEW = 'Новий';

    /**
     * The pending order status.
     *
     * @var string
     */
    const PENDING = 'В очікуванні';

    /**
     * The done order status.
     *
     * @var string
     */
    const DONE = 'Зроблено';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 'status', 'total', 'notes',
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
     * Get statuses.
     *
     * @return string[]
     */
    public static function statuses()
    {
        return [
            self::NEW,
            self::PENDING,
            self::DONE,
        ];
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
     * @return float
     */
    public function getDecimalTotalAttribute()
    {
        return number_format($this->total / 100, 2, '.', '');
    }
}
