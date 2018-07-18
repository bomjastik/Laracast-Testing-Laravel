<?php

namespace Tests\Unit;

use App\Order;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    private $order;

    public function setUp()
    {
        $this->order = $this->createOrderWithProducts();
    }

    /** @test */
    public function it_consists_of_products()
    {
        $this->assertCount(2, $this->order->products());
    }

    /** @test */
    public function it_can_determine_a_total_cost_of_all_its_products()
    {
        $this->assertEquals(66, $this->order->total());
    }

    private function createOrderWithProducts(): Order
    {
        $order = new Order;

        $product1 = new Product([
            'name' => 'Fallout 4',
            'price' => 59
        ]);

        $product2 = new Product([
            'name' => 'Pillowcase',
            'price' => 7
        ]);

        $order->add($product1);
        $order->add($product2);

        return $order;
    }
}
