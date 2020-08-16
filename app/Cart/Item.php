<?php

namespace App\Cart;

class Item
{
    /**
     * Item id.
     *
     * @var int
     */
    public $id;

    /**
     * Item name.
     *
     * @var string
     */
    public $name;

    /**
     * Item category.
     *
     * @var string
     */
    public $category;

    /**
     * Item Price.
     *
     * @var int
     */
    public $price;

    /**
     * Item quantity.
     *
     * @var int
     */
    public $quantity;

    /**
     * Item image.
     *
     * @var int
     */
    public $image;

    /**
     * Item constructor.
     *
     * @param  \App\Product  $product
     * @param  int  $quantity
     */
    public function __construct($product, $quantity = 1)
    {
        $this->id = $product->id;
        $this->name = $product->name;
        $this->category = $product->category->name;
        $this->price = $product->price;
        $this->quantity = $quantity;
        $this->image = $product->defaultImage()->path;
    }

    /**
     * Get item total price.
     *
     * @return int
     */
    public function total()
    {
        return $this->quantity * $this->price;
    }
}
