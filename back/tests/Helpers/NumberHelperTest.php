<?php

namespace Tests\Helpers;

use PHPUnit\Framework\TestCase;

class NumberHelperTest extends TestCase
{
    public function testShouldToDecimal()
    {
        $this->assertEquals(0, \Helpers\NumberHelper::toDecimal(''));
        $this->assertEquals(0, \Helpers\NumberHelper::toDecimal('a'));
        $this->assertEquals(0, \Helpers\NumberHelper::toDecimal('1a'));
        $this->assertEquals(0, \Helpers\NumberHelper::toDecimal('1.1a'));
        $this->assertEquals(0, \Helpers\NumberHelper::toDecimal('1,1a'));
        $this->assertEquals(0, \Helpers\NumberHelper::toDecimal('1,1a'));
        $this->assertEquals(0, \Helpers\NumberHelper::toDecimal('1,1a'));
        $this->assertEquals(0, \Helpers\NumberHelper::toDecimal('1,1a'));
        $this->assertEquals(0, \Helpers\NumberHelper::toDecimal('1,1a'));
        $this->assertEquals(0, \Helpers\NumberHelper::toDecimal('1,1a'));
        $this->assertEquals(0, \Helpers\NumberHelper::toDecimal('1,1a'));
        $this->assertEquals(0, \Helpers\NumberHelper::toDecimal('1,1a'));
        $this->assertEquals(1.1, \Helpers\NumberHelper::toDecimal('1.1'));
        $this->assertEquals(1.1, \Helpers\NumberHelper::toDecimal('1,1'));
        $this->assertEquals(1.1, \Helpers\NumberHelper::toDecimal('1,1'));
        $this->assertEquals(1.1, \Helpers\NumberHelper::toDecimal('1,1'));
        $this->assertEquals(1.1, \Helpers\NumberHelper::toDecimal('1,1'));
        $this->assertEquals(1.1, \Helpers\NumberHelper::toDecimal('1,1'));
        $this->assertEquals(1.1, \Helpers\NumberHelper::toDecimal('1,1'));
        $this->assertEquals(1.1, \Helpers\NumberHelper::toDecimal('1,1'));
        $this->assertEquals(1.1, \Helpers\NumberHelper::toDecimal('1,1'));
    }

    public function testShouldNullOrInt(){
        $this->assertEquals(null, \Helpers\NumberHelper::intNull(''));
        $this->assertEquals(null, \Helpers\NumberHelper::intNull('a'));
        $this->assertEquals(1, \Helpers\NumberHelper::intNull('1'));
        $this->assertEquals(1, \Helpers\NumberHelper::intNull('1,0'));
        $this->assertEquals(1, \Helpers\NumberHelper::intNull('1.0'));
        $this->assertEquals(1, \Helpers\NumberHelper::intNull('1,00'));
        $this->assertEquals(1, \Helpers\NumberHelper::intNull('1.00'));
        $this->assertEquals(1, \Helpers\NumberHelper::intNull('1,000'));
        $this->assertEquals(1, \Helpers\NumberHelper::intNull('1.000'));
        $this->assertEquals(1, \Helpers\NumberHelper::intNull('1,0000'));
        $this->assertEquals(1, \Helpers\NumberHelper::intNull('1.0000'));
    }
}
