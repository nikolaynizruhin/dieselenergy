<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Filters\Filterable;
use App\Support\Money;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['customer_id', 'status', 'total', 'notes'])]
class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use Filterable, HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['status' => OrderStatus::class];
    }

    /**
     * Get the customer that owns the order.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * The products that belong to the order.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->using(Cart::class)
            ->withPivot('id', 'quantity')
            ->withTimestamps();
    }

    /**
     * Calculate and update order total.
     */
    public function updateTotal(): void
    {
        $this->update(['total' => $this->getTotal()]);
    }

    /**
     * Get order total.
     */
    public function getTotal(): int
    {
        return $this->products->sum(fn ($product) => $product->price->toUAH()->coins() * $product->pivot->quantity);
    }

    /**
     * Total price.
     */
    protected function total(): Attribute
    {
        return new Attribute(fn ($value) => new Money($value));
    }
}
