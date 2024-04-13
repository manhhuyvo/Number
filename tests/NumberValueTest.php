<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Number\Entity\Number;

final class NumberValueTest extends TestCase
{
    public function testCanBeCreatedFromIntegerAsStringValue(): void
    {
        $this->assertInstanceOf(Number::class, Number::of('123456'));
    }
    
    public function testCanBeCreatedFromIntegerValue(): void
    {
        $this->assertInstanceOf(Number::class, Number::of(123456));
    }

    public function testCanBeCreatedFromFloatAsStringValue(): void
    {
        $this->assertInstanceOf(Number::class, Number::of('123.456'));
    }
    
    public function testCanBeCreatedFromFloatValue(): void
    {
        $this->assertInstanceOf(Number::class, Number::of(123.456));
    }

    public function testCanBeCreatedFromNull(): void
    {
        $this->assertInstanceOf(Number::class, Number::of(null));
    }

    public function testCanBeCreatedFromNegativeNumberAsStringValue(): void
    {
        $this->assertInstanceOf(Number::class, Number::of('-123'));
        $this->assertInstanceOf(Number::class, Number::of('-123.456'));
        $this->assertInstanceOf(Number::class, Number::of('-123.000'));
    }

    public function testCanBeCreatedFromNegativeNumberAsFloatValue(): void
    {
        $this->assertInstanceOf(Number::class, Number::of(-123.000));
        $this->assertInstanceOf(Number::class, Number::of(-123.456));
    }

    public function testCanBeCreatedFromNegativeNumberAsIntValue(): void
    {
        $this->assertInstanceOf(Number::class, Number::of(-123));
        $this->assertInstanceOf(Number::class, Number::of(-999999999999));
    }

    public function testCanBeMadeAsZero(): void
    {
        $this->assertInstanceOf(Number::class, Number::of(0));
        $this->assertInstanceOf(Number::class, Number::zero());
        $this->assertSame(0, Number::zero()->toInt());
    }

    public function testGlobalScaleCanBeSet(): void
    {
        Number::setGlobalScale(5);
        $currentScale = bcscale();

        $this->assertSame(5, $currentScale);
    }

    public function testGetValueFromStringTypeInstance(): void
    {
        $number = Number::of('123.456');
        $this->assertSame('123.456', $number->toString());
        $this->assertSame(123.456, $number->toFloat());
        $this->assertSame(123, $number->toInt());
        
        $number = Number::of('123');
        $this->assertSame('123', $number->toString());
        $this->assertSame(123.0, $number->toFloat());
        $this->assertSame(123, $number->toInt());
        
        $number = Number::of('123.999999999999999999999999999999');
        $this->assertSame('124', $number->toString());
        $this->assertSame(123.999999999999999999999999999999, $number->toFloat());
        $this->assertSame(124, $number->toInt());
        
        $number = Number::of('456.49999999999');
        $this->assertSame('456.49999999999', $number->toString());
        $this->assertSame(456.49999999999, $number->toFloat());
        $this->assertSame(456, $number->toInt());
        
        $number = Number::of('456.499999999999');
        $this->assertSame('456.5', $number->toString());
        $this->assertSame(456.499999999999, $number->toFloat());
        $this->assertSame(456, $number->toInt());
    }

    public function testGetValueFromFloatTypeInstance(): void
    {
        $number = Number::of(123.456);
        $this->assertSame('123.456', $number->toString());
        $this->assertSame(123.456, $number->toFloat());
        $this->assertSame(123, $number->toInt());
        
        $number = Number::of(123.00);
        $this->assertSame('123', $number->toString());
        $this->assertSame(123.00, $number->toFloat());
        $this->assertSame(123, $number->toInt());
        
        $number = Number::of(123.999999999999999999999999999999);
        $this->assertSame('124', $number->toString());
        $this->assertSame(123.999999999999999999999999999999, $number->toFloat());
        $this->assertSame(124, $number->toInt());
        
        $number = Number::of(456.49999999999);
        $this->assertSame('456.49999999999', $number->toString());
        $this->assertSame(456.49999999999, $number->toFloat());
        $this->assertSame(456, $number->toInt());
        
        $number = Number::of(456.499999999999);
        $this->assertSame('456.5', $number->toString());
        $this->assertSame(456.499999999999, $number->toFloat());
        $this->assertSame(456, $number->toInt());
    }

    public function testGetValueFromIntTypeInstance(): void
    {
        $number = Number::of(123);
        $this->assertSame('123', $number->toString());
        $this->assertSame(123.0, $number->toFloat());
        $this->assertSame(123, $number->toInt());
        
        $number = Number::of(99999999999999);
        $this->assertSame('99999999999999', $number->toString());
        $this->assertSame(99999999999999.0, $number->toFloat());
        $this->assertSame(99999999999999, $number->toInt());
    }

    public function testGetValueFromNullTypeInstance(): void
    {
        $number = Number::of(null);
        $this->assertSame('0', $number->toString());
        $this->assertSame(0.0, $number->toFloat());
        $this->assertSame(0, $number->toInt());
    }

    public function testGetValueFromZeroTypeInstance(): void
    {
        $number = Number::of(0);
        $this->assertSame('0', $number->toString());
        $this->assertSame(0.0, $number->toFloat());
        $this->assertSame(0, $number->toInt());
    }

    public function testGetValueFromNegativeInstance(): void
    {
        $number = Number::of('-123');
        $this->assertSame('-123', $number->toString());
        $this->assertSame(-123.0, $number->toFloat());
        $this->assertSame(-123, $number->toInt());
        
        $number = Number::of('-123.456');
        $this->assertSame('-123.456', $number->toString());
        $this->assertSame(-123.456, $number->toFloat());
        $this->assertSame(-123, $number->toInt());
        
        $number = Number::of('-123.999999999');
        $this->assertSame('-123.999999999', $number->toString());
        $this->assertSame(-123.999999999, $number->toFloat());
        $this->assertSame(-123, $number->toInt());
        
        $number = Number::of('-123.0000000000');
        $this->assertSame('-123', $number->toString());
        $this->assertSame(-123.0, $number->toFloat());
        $this->assertSame(-123, $number->toInt());
    }

    public function testSetValueFromStringType(): void
    {
        $number = Number::zero();

        $number = $number->setValue('123.456');
        $this->assertSame(123.456, $number->toFloat());

        $number = $number->setValue('123.99999999999');
        $this->assertSame(123.99999999999, $number->toFloat());

        $number = $number->setValue('123.00000000000');
        $this->assertSame(123.0, $number->toFloat());
    }

    public function testSetValueFromFloatType(): void
    {
        $number = Number::zero();

        $number = $number->setValue(123.456);
        $this->assertSame(123.456, $number->toFloat());

        $number = $number->setValue(123.99999999999);
        $this->assertSame(123.99999999999, $number->toFloat());

        $number = $number->setValue(123.00000000000);
        $this->assertSame(123.0, $number->toFloat());
    }

    public function testSetValueFromIntType(): void
    {
        $number = Number::zero();

        $number = $number->setValue(123456);
        $this->assertSame(123456, $number->toInt());
        $this->assertSame(123456.0, $number->toFloat());
    }

    public function testSetValueFromNullType(): void
    {
        $number = Number::of('123.456');

        $number = $number->setValue(null);
        $this->assertSame(0, $number->toInt());
        $this->assertSame(0.0, $number->toFloat());
    }

    public function testSetAbsoluteValueFromFloatType(): void
    {
        $number = Number::of(123.456);
        $this->assertSame(123.456, $number->absolute()->toFloat());

        $number = Number::of(-123.456);
        $this->assertSame(123.456, $number->absolute()->toFloat());

        $number = Number::of(123.999999999);
        $this->assertSame(123.999999999, $number->absolute()->toFloat());

        $number = Number::of(-123.999999999);
        $this->assertSame(123.999999999, $number->absolute()->toFloat());

        $number = Number::of(123.000);
        $this->assertSame(123.0, $number->absolute()->toFloat());

        $number = Number::of(-123.000);
        $this->assertSame(123.0, $number->absolute()->toFloat());
    }
}