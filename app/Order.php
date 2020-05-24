<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const NEW = 'New';
    const PENDING = 'Pending';
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
}
