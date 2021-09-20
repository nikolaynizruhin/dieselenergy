<?php

namespace App\Cart;

use App\Models\Order;
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
     * Session manager.
     *
     * @var SessionManager
     */
    private SessionManager $session;

    /**
     * Cart constructor.
     *
     * @param  SessionManager  $session
     */
    public function __construct(SessionManager $session)
    {
        $this->session = $session;
    }

    /**
     * Add product to cart.
     *
     * @param  \App\Models\Product  $product
     * @param  int  $quantity
     * @return \App\Cart\Item
     */
    public function add($product, $quantity = 1)
    {
        $items = $this->items();

        $key = $items->search(fn ($item) => $item->id === $product->id);

        if ($key === false) {
            $item = new Item($product, $quantity);
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
    public function items()
    {
        return $this->session->get(self::KEY, new Collection());
    }

    public function update($key, $quantity)
    {
        $items = $this->items();

        $item = $items->get($key);

        $item->quantity = $quantity;

        $items->put($key, $item);

        $this->session->put(self::KEY, $items);

        return $item;
    }

    /**
     * Get cart total.
     *
     * @return int
     */
    public function total()
    {
        return $this->items()->sum(fn ($item) => $item->price * $item->quantity);
    }

    /**
     * Clear a cart.
     */
    public function clear()
    {
        $this->session->put(self::KEY, new Collection());
    }

    /**
     * Store a cart.
     *
     * @param  \App\Models\Order  $order
     */
    public function store(Order $order)
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
     */
    public function delete($key)
    {
        $items = $this->items();

        $items->forget($key);

        $this->session->put(self::KEY, $items);
    }
}
