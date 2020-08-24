<?php

namespace App;

use App\Notifications\OrderConfirmed;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    use HasSearch, Notifiable;

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
     * Get the contacts for the customer.
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Create a new order.
     *
     * @param string $notes
     * @return \App\Order
     */
    public function createNewOrder($notes = '')
    {
        return $this->orders()->create([
            'status' => Order::NEW,
            'notes' => $notes,
        ]);
    }

    /**
     * Send the order confirmation notification.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function sendOrderConfirmationNotification($order)
    {
        $this->notify(new OrderConfirmed($order));
    }
}
