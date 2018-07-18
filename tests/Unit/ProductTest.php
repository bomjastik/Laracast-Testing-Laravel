<?php

namespace Tests\Unit;

use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    private $product;

    public function setUp()
    {
        $this->product = new Product([
            'name' => 'Fallout 4',
            'price' => 59
        ]);
    }

    /** @test */
    public function it_has_name()
    {
        $this->assertEquals('Fallout 4', $this->product->name());
    }

    /** @test */
    public function it_has_price()
    {
        $this->assertEquals(59, $this->product->price());
    }
}
