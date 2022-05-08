<?php

namespace App\Support;

use App\Models\Product;

class CartItem
{
    /**
     * Item id.
     *
     * @var int
     */
    public int $id;

    /**
     * Item slug.
     *
     * @var string
     */
    public string $slug;

    /**
     * Item name.
     *
     * @var string
     */
    public string $name;

    /**
     * Item category.
     *
     * @var string
     */
    public string $category;

    /**
     * Item Price.
     *
     * @var float
     */
    public float $price;

    /**
     * Item quantity.
     *
     * @var int
     */
    public int $quantity;

    /**
     * Item image.
     *
     * @var string
     */
    public string $image;

    /**
     * Item constructor.
     *
     * @param  \App\Models\Product  $product
     * @param  int  $quantity
     */
    public function __construct(Product $product, int $quantity = 1)
    {
        $this->id = $product->id;
        $this->slug = $product->slug;
        $this->name = $product->name;
        $this->category = $product->category->name;
        $this->price = $product->price->toUAH()->coins();
        $this->quantity = $quantity;
        $this->image = $product->defaultImage()->path;
    }

    /**
     * Get item total price.
     *
     * @return float
     */
    public function total(): float
    {
        return $this->quantity * $this->price;
    }
}
