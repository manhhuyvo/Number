<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Number\Entity\Number;

class NumberCalculationTest extends TestCase
{    
    public function testPlusOperations()
    {
        // Set global scale as 5
        Number::setGlobalScale(5);
        
        /** INTEGER */
        $num1 = Number::of(125);
        $num2 = Number::of(654);
        $num3 = Number::of(1235);

        $this->assertSame(779.0, $num1->copy()->plus($num2)->toFloat());
        $this->assertSame(1889.0, $num2->copy()->plus($num3)->toFloat());
        $this->assertSame(1360.0, $num1->copy()->plus($num3)->toFloat());
        // Chain plus for all numbers
        $this->assertSame(2014.0, $num1->copy()->plus($num2)->plus($num3)->toFloat());

        /** FLOAT */
        $num1 = Number::of(125.75);
        $num2 = Number::of(6595.65);
        $num3 = Number::of(723.9654);
        $num4 = Number::of(9999.99999);

        $this->assertSame(6721.4, $num1->copy()->plus($num2)->toFloat());        
        $this->assertSame(7319.6154, $num2->copy()->plus($num3)->toFloat());
        $this->assertSame(849.7154, $num1->copy()->plus($num3)->toFloat());
        $this->assertSame(10723.96539, $num3->copy()->plus($num4)->toFloat());
        // Chain plus for all numbers
        $this->assertSame(17445.36539, $num1->copy()->plus($num2)->plus($num3)->plus($num4)->toFloat());
    }
    
    public function testMinusOperations()
    {
        // Set global scale as 5
        Number::setGlobalScale(5);
        
        /** INTEGER */
        $num1 = Number::of(125);
        $num2 = Number::of(654);
        $num3 = Number::of(1235);

        $this->assertSame(-529.0, $num1->copy()->minus($num2)->toFloat());
        $this->assertSame(-581.0, $num2->copy()->minus($num3)->toFloat());
        $this->assertSame(-1110.0, $num1->copy()->minus($num3)->toFloat());
        $this->assertSame(529.0, $num2->copy()->minus($num1)->toFloat());
        $this->assertSame(1110.0, $num3->copy()->minus($num1)->toFloat());
        // Chain plus for all numbers
        $this->assertSame(456.0, $num3->copy()->minus($num2)->minus($num1)->toFloat());


        // Set global scale as 5
        Number::setGlobalScale(5);

        $num1 = Number::of(125.75);
        $num2 = Number::of(6595.65);
        $num3 = Number::of(723.9654);
        $num4 = Number::of(9999.99999);

        $this->assertSame(-6469.9, $num1->copy()->minus($num2)->toFloat());        
        $this->assertSame(5871.6846, $num2->copy()->minus($num3)->toFloat());
        $this->assertSame(-598.2154, $num1->copy()->minus($num3)->toFloat());
        $this->assertSame(-9276.03459, $num3->copy()->minus($num4)->toFloat());
        // Chain plus for all numbers
        $this->assertSame(2554.63459, $num4->copy()->minus($num3)->minus($num2)->minus($num1)->toFloat());
    }
}