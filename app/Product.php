<?php

namespace App;

class Product
{
    protected $name;
    protected $price;

    public function __construct($name = 'default', $price = 0)
    {
        $this->name = $name;
        $this->price = $price;
    }

    public function name()
    {
        return $this->name;
    }
    public function price()
    {
        return $this->price;
    }
}
