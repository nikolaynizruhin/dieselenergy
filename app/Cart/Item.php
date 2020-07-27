<?php

namespace App\Cart;

class Item
{
    /**
     * Item id.
     *
     * @var int
     */
    private $id;

    /**
     * Item name.
     *
     * @var int
     */
    private $name;

    /**
     * Item category.
     *
     * @var int
     */
    private $category;

    /**
     * Item Price.
     *
     * @var int
     */
    private $price;

    /**
     * Item quantity.
     *
     * @var int
     */
    private $quantity;

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
     * Increment quantity.
     */
    public function incrementQuantity()
    {
        $this->quantity++;
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
