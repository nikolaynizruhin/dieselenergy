<?php

namespace App\Support;

use App\Models\Product;

class CartItem
{
    /**
     * Item id.
     */
    public int $id;

    /**
     * Item slug.
     */
    public string $slug;

    /**
     * Item name.
     */
    public string $name;

    /**
     * Item category.
     */
    public string $category;

    /**
     * Item Price.
     */
    public float $price;

    /**
     * Item quantity.
     */
    public int $quantity;

    /**
     * Item image.
     */
    public string $image;

    /**
     * Item constructor.
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
     */
    public function total(): float
    {
        return $this->quantity * $this->price;
    }
}
