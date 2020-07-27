<?php

namespace App\Cart;

use Illuminate\Session\SessionManager;
use Illuminate\Support\Collection;

class Cart
{
    /**
     * @var SessionManager
     */
    private SessionManager $session;

    public function __construct(SessionManager $session)
    {
        $this->session = $session;
    }

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

    public function items()
    {
        return $this->session->get('cart', new Collection());
    }

    public function delete($key)
    {
        $items = $this->items();

        $items->forget($key);

        $this->session->put('cart', $items);
    }
}
