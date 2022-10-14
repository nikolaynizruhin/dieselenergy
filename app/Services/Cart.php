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
     *
     * @param  SessionManager  $session
     */
    public function __construct(readonly private SessionManager $session)
    {
    }

    /**
     * Add product to cart.
     *
     * @param  \App\Models\Product  $product
     * @param  int  $quantity
     * @return \App\Support\CartItem
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
     *
     * @return \Illuminate\Support\Collection
     */
    public function items(): Collection
    {
        return $this->session->get(self::KEY, new Collection());
    }

    /**
     * Update cart.
     *
     * @param  string  $key
     * @param  int  $quantity
     * @return bool
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
     *
     * @return int
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
        $this->session->put(self::KEY, new Collection());
    }

    /**
     * Store a cart.
     *
     * @param  \App\Models\Order  $order
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
     *
     * @param  string  $key
     * @return bool
     */
    public function delete(string $key): bool
    {
        $items = $this->items();

        $items->forget($key);

        $this->session->put(self::KEY, $items);

        return true;
    }
}
