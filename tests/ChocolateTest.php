<?php

use PHPUnit\Framework\TestCase;
use Chocola\Chocolate;

class ChocolateTest extends TestCase
{
    public function testBasicCase()
    {
        $chocolate = new Chocolate(3, 3, [2, 1], [3, 1]);
        $this->assertEquals(12, $chocolate->getMinCost());
    }

    public function testAllEqualCosts()
    {
        $chocolate = new Chocolate(4, 4, [1, 1, 1], [1, 1, 1]);
        $this->assertEquals(15, $chocolate->getMinCost());
    }

    public function testOnlyHorizontalCheaper()
    {
        $chocolate = new Chocolate(3, 3, [1, 1], [100, 100]);
        $this->assertEquals(206, $chocolate->getMinCost());
    }

    public function testOnlyVerticalCheaper()
    {
        $chocolate = new Chocolate(3, 3, [100, 100], [1, 1]);
        $this->assertEquals(206, $chocolate->getMinCost());
    }

    public function testLargeInput()
    {
        $x = array_fill(0, 999, 1000);
        $y = array_fill(0, 999, 1000);
        $chocolate = new Chocolate(1000, 1000, $x, $y);
        $this->assertIsInt($chocolate->getMinCost());
    }
}