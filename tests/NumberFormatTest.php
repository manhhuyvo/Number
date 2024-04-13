<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Number\Entity\Number;

final class NumberFormatTest extends TestCase
{
    public function testNumberFormatDefaultSettings(): void
    {
        $this->assertSame('123,456', Number::of(123456)->numberFormat());

        $this->assertSame('123,456', Number::of(123456.000000000)->numberFormat());

        $this->assertSame('123,456', Number::of(123456.499999999)->numberFormat());

        $this->assertSame('123,456', Number::of(123456.111111111)->numberFormat());

        $this->assertSame('123,457', Number::of(123456.500000000)->numberFormat());

        $this->assertSame('123,457', Number::of(123456.599999999)->numberFormat());

        $this->assertSame('123,457', Number::of(123456.999999999)->numberFormat());
    }

    public function testNumberFormatWithCustomDecimals(): void
    {
        $number = Number::of(123456);
        $this->assertSame('123,456.0', $number->numberFormat(1));
        $this->assertSame('123,456.00', $number->numberFormat(2));
        $this->assertSame('123,456.000000000', $number->numberFormat(9));
        
        $number = Number::of(123456.999999999);
        $this->assertSame('123,457.0', $number->numberFormat(1));
        $this->assertSame('123,457.00', $number->numberFormat(2));
        $this->assertSame('123,456.999999999', $number->numberFormat(9));
        
        $number = Number::of(123456.99);
        $this->assertSame('123,457.0', $number->numberFormat(1));
        $this->assertSame('123,456.99', $number->numberFormat(2));
        $this->assertSame('123,456.990000000', $number->numberFormat(9));
        
        $number = Number::of(123456.499999999);
        $this->assertSame('123,456.5', $number->numberFormat(1));
        $this->assertSame('123,456.50', $number->numberFormat(2));
        $this->assertSame('123,456.499999999', $number->numberFormat(9));
        
        $number = Number::of(123456.599999999);
        $this->assertSame('123,456.6', $number->numberFormat(1));
        $this->assertSame('123,456.60', $number->numberFormat(2));
        $this->assertSame('123,456.599999999', $number->numberFormat(9));
        
        $number = Number::of(123456.512311199);
        $this->assertSame('123,456.5', $number->numberFormat(1));
        $this->assertSame('123,456.51', $number->numberFormat(2));
        $this->assertSame('123,456.5123112', $number->numberFormat(7));
        $this->assertSame('123,456.51231120', $number->numberFormat(8));
        $this->assertSame('123,456.512311199', $number->numberFormat(9));
    }

    public function testNumberFormatWithCustomDecimalSeparator(): void
    {
        $number = Number::of(123456);
        $this->assertSame('123,456/0', $number->numberFormat(1, '/'));
        $this->assertSame('123,456|00', $number->numberFormat(2, '|'));
        $this->assertSame('123,456,000000000', $number->numberFormat(9, ','));
        
        $number = Number::of(123456.999999999);
        $this->assertSame('123,457%0', $number->numberFormat(1, '%'));
        $this->assertSame('123,457!00', $number->numberFormat(2, '!'));
        $this->assertSame('123,456@999999999', $number->numberFormat(9, '@'));
        
        $number = Number::of(123456.99);
        $this->assertSame('123,457#0', $number->numberFormat(1, '#'));
        $this->assertSame('123,456^99', $number->numberFormat(2, '^'));
        $this->assertSame('123,456dot990000000', $number->numberFormat(9, 'dot'));
        
        $number = Number::of(123456.499999999);
        $this->assertSame('123,456test5', $number->numberFormat(1, 'test'));
        $this->assertSame('123,456<br>50', $number->numberFormat(2, '<br>'));
        $this->assertSame('123,456thisistest499999999', $number->numberFormat(9, 'thisistest'));
    }

    public function testNumberFormatWithCustomThousandsSeparator(): void
    {
        $number = Number::of(123456);
        $this->assertSame('123/456.0', $number->numberFormat(1, null, '/'));
        $this->assertSame('123|456.00', $number->numberFormat(2, null, '|'));
        $this->assertSame('123)456.000000000', $number->numberFormat(9, null, ')'));
        
        $number = Number::of(123456.999999999);
        $this->assertSame('123%457.0', $number->numberFormat(1, null, '%'));
        $this->assertSame('123!457.00', $number->numberFormat(2, null, '!'));
        $this->assertSame('123@456.999999999', $number->numberFormat(9, null, '@'));
        
        $number = Number::of(123456.99);
        $this->assertSame('123#457.0', $number->numberFormat(1, null, '#'));
        $this->assertSame('123^456.99', $number->numberFormat(2, null, '^'));
        $this->assertSame('123comma456.990000000', $number->numberFormat(9, null, 'comma'));
        
        $number = Number::of(123456.499999999);
        $this->assertSame('123test456.5', $number->numberFormat(1, null, 'test'));
        $this->assertSame('123<br>456.50', $number->numberFormat(2, null, '<br>'));
        $this->assertSame('123thisistest456.499999999', $number->numberFormat(9, null, 'thisistest'));
    }
}