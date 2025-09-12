<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Support\CartItem;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Collection;

class Cart
{
    /**
     * Session cart key.
     *
     * @var string
     */
    const KEY = 'cart';

    /**
     * Cart constructor.
     */
    public function __construct(private readonly SessionManager $session) {}

    /**
     * Add product to cart.
     */
    public function add(Product $product, int $quantity = 1): CartItem
    {
        $items = $this->items();

        $key = $items->search(fn ($item) => $item->id === $product->id);

        if ($key === false) {
            $item = new CartItem($product, $quantity);
            $items->push($item);
        } else {
            $item = $items->get($key);
            $item->quantity += $quantity;
            $items->put($key, $item);
        }

        $this->session->put(self::KEY, $items);

        return $item;
    }

    /**
     * Get items.
     */
    public function items(): Collection
    {
        return $this->session->get(self::KEY, new Collection);
    }

    /**
     * Update cart.
     */
    public function update(string $key, int $quantity): bool
    {
        $items = $this->items();

        $item = $items->get($key);

        $item->quantity = $quantity;

        $items->put($key, $item);

        $this->session->put(self::KEY, $items);

        return true;
    }

    /**
     * Get cart total.
     */
    public function total(): int
    {
        return $this->items()->sum(fn ($item) => $item->price * $item->quantity);
    }

    /**
     * Clear a cart.
     */
    public function clear(): void
    {
        $this->session->put(self::KEY, new Collection);
    }

    /**
     * Store a cart.
     */
    public function store(Order $order): void
    {
        $products = $this->items()->mapWithKeys(fn ($item) => [
            $item->id => ['quantity' => $item->quantity],
        ]);

        $order->products()->attach($products->all());

        $this->clear();
    }

    /**
     * Delete item.
     */
    public function delete(string $key): bool
    {
        $items = $this->items();

        $items->forget($key);

        $this->session->put(self::KEY, $items);

        return true;
    }
}
