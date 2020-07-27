<?php

namespace App\Cart;

use Illuminate\Session\SessionManager;
use Illuminate\Support\Collection;

class Cart
{
    /**
     * Session manager.
     *
     * @var SessionManager
     */
    private SessionManager $session;

    /**
     * Cart constructor.
     *
     * @param SessionManager $session
     */
    public function __construct(SessionManager $session)
    {
        $this->session = $session;
    }

    /**
     * Add product to cart.
     *
     * @param  \App\Product  $product
     * @return Item
     */
    public function add($product)
    {
        $items = $this->items();

        $key = $items->search(fn ($item) => $item->id == $product->id);

        if ($key === false) {
            $item = new Item($product);
            $items->push($item);
        } else {
            $item = $items->get($key);
            $item->incrementQuantity();
            $items->put($key, $item);
        }

        $this->session->put('cart', $items);

        return $item;
    }

    /**
     * Get items.
     *
     * @return \Illuminate\Support\Collection
     */
    public function items()
    {
        return $this->session->get('cart', new Collection());
    }

    /**
     * Delete item.
     *
     * @param int $key
     */
    public function delete($key)
    {
        $items = $this->items();

        $items->forget($key);

        $this->session->put('cart', $items);
    }
}
