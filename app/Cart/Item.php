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
     * @var int
     */
    public $name;

    /**
     * Item category.
     *
     * @var int
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

    /**
     * Get item attribute.
     *
     * @param  string  $attribute
     * @return mixed
     */
    public function __get($attribute)
    {
        return $this->{$attribute};
    }
}
