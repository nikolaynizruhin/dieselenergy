<?php

namespace App\Models;

use App\HasSearch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, HasSearch;

    /**
     * The new order status.
     *
     * @var string
     */
    const NEW = 'New';

    /**
     * The pending order status.
     *
     * @var string
     */
    const PENDING = 'Pending';

    /**
     * The done order status.
     *
     * @var string
     */
    const DONE = 'Done';

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
     * Scope a query to search by customer attribute.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $attribute
     * @param  string  $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchByCustomer($query, $attribute, $search)
    {
        return $query->whereHas(
            'customer',
            fn (Builder $query) => $query->where($attribute, 'like', '%'.$search.'%')
        );
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
        return $this->products->sum(fn ($product) => $product->price * $product->pivot->quantity);
    }
}