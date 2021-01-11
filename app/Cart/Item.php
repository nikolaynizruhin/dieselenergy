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
     * Item slug.
     *
     * @var string
     */
    public $slug;

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
     * @var float
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
     * @var string
     */
    public $image;

    /**
     * Item constructor.
     *
     * @param  \App\Models\Product  $product
     * @param  int  $quantity
     */
    public function __construct($product, $quantity = 1)
    {
        $this->id = $product->id;
        $this->slug = $product->slug;
        $this->name = $product->name;
        $this->category = $product->category->name;
        $this->price = $product->uah_price;
        $this->quantity = $quantity;
        $this->image = $product->defaultImage()->path;
    }

    /**
     * Get item total price.
     *
     * @return float
     */
    public function total()
    {
        return $this->quantity * $this->price;
    }
}
