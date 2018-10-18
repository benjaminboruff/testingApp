<?php

namespace Tests\Unit;

# use Tests\TestCase;
use PHPUnit\Framework\TestCase;
use App\Product;

class ProductTest extends TestCase
{
    protected $product;

    protected function setUp()
    {
        $this->product = new Product('Dude', 1.5);
    }

    /** @test */
    public function a_product_has_defaults()
    {
        $defaultProduct = new Product();
        $this->assertEquals($defaultProduct->name(), 'default');
        $this->assertEquals($defaultProduct->price(), 0);
    }
    /** @test */
    public function a_product_has_a_name()
    {
        $this->assertEquals($this->product->name(), 'Dude');
    }
    /** @test */
    public function a_product_has_a_price()
    {
        $this->assertEquals($this->product->price(), 1.50);
    }
}
