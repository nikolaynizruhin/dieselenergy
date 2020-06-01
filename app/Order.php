<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The new order status.
     *
     * @var string
     */
    const STATUS_NEW = 'New';

    /**
     * The pending order status.
     *
     * @var string
     */
    const STATUS_PENDING = 'Pending';

    /**
     * The done order status.
     *
     * @var string
     */
    const STATUS_DONE = 'Done';

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
            self::STATUS_NEW,
            self::STATUS_PENDING,
            self::STATUS_DONE,
        ];
    }
}
