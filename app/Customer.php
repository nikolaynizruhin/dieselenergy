<?php

namespace App;

use Facades\App\Cart\Cart;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasSearch;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'notes',
    ];

    /**
     * Get the orders for the customer.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Create a new order.
     *
     * @param string $notes
     * @return \App\Order
     */
    public function createNewOrder($notes = '')
    {
        $order = $this->orders()->create([
            'status' => Order::NEW,
            'notes' => $notes,
        ]);

        Cart::store($order);

        Cart::clear();

        return $order;
    }
}
