<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Order;
use App\Product;

class OrderTest extends TestCase
{
    public function setUp()
    {
        $this->order = new Order;
        $product1 = new Product('widget1', 2.00);
        $product2 = new Product('widget2', 10.75);
        $product3 = new Product('widget3');

        $this->order->add($product1);
        $this->order->add($product2);
        $this->order->add($product3);
        // var_dump($order->products());
        // die();
    }

    /** @test */
    public function an_order_consists_of_products()
    {
        $this->assertCount(3, $this->order->products());
    }

    /** @test */
    public function an_order_can_total_the_prices_of_its_products()
    {
        $this->assertEquals(12.75, $this->order->total());
    }
}
