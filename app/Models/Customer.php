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
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use Filterable, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'email', 'phone', 'notes',
    ];

    /**
     * Get the orders for the customer.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the contacts for the customer.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Create a new order.
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
     */
    public function createContact(string $message): Contact
    {
        return $this->contacts()->create(compact('message'));
    }

    /**
     * Send the order confirmation notification.
     */
    public function sendOrderConfirmationNotification(Order $order): void
    {
        $this->notify(new OrderConfirmed($order));
    }
}
