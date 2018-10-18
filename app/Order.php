<?php

namespace App;

class Order
{
    protected $products = [];
    protected $total = 0;

    public function products()
    {
        return $this->products;
    }
    public function price()
    {
        return $this->price;
    }
    public function add(Product $product)
    {
        $this->products[] = $product;
    }
    public function total()
    {
        foreach ($this->products as $product) {
            $this->total += $product->price();
        }

        return $this->total;
    }
}
