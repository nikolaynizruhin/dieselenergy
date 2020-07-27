<?php

namespace App\Cart;

class Item
{
    private $id;
    private $name;
    private $category;
    private $price;
    private $quantity;

    public function __construct($product, $quantity = 1)
    {
        $this->id = $product->id;
        $this->name = $product->name;
        $this->category = $product->category->name;
        $this->price = $product->price;
        $this->quantity = $quantity;
    }

    public function incrementQuantity()
    {
        $this->quantity++;
    }

    public function __get($attribute)
    {
        return $this->{$attribute};
    }
}
