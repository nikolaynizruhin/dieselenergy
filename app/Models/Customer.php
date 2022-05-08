<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Filters\Filterable;
use App\Notifications\OrderConfirmed;
use Facades\App\Services\Cart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    use HasFactory, Filterable, Notifiable;

    /**
     * Phone number regex pattern.
     *
     * @var string
     */
    const PHONE_REGEX = '/^\+380[0-9]{9}$/';

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
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the contacts for the customer.
     *
     * @return HasMany
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Create a new order.
     *
     * @param  string  $notes
     * @return \App\Models\Order
     */
    public function createOrder(string $notes = ''): Order
    {
        $order = $this->orders()->create([
            'status' => OrderStatus::New,
            'notes' => $notes,
        ]);

        Cart::store($order);

        return $order;
    }

    /**
     * Create contact.
     *
     * @param  string  $message
     * @return \App\Models\Contact
     */
    public function createContact(string $message): Contact
    {
        return $this->contacts()->create(['message' => $message]);
    }

    /**
     * Send the order confirmation notification.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function sendOrderConfirmationNotification(Order $order)
    {
        $this->notify(new OrderConfirmed($order));
    }
}
