<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Number\Entity\Number;
use Number\Constant\RoundingMode;

final class NumberRoundTest extends TestCase
{
    public function testRoundValueDefaultSettings(): void
    {
        $number = Number::of(123456);
        $this->assertSame(123456.0, $number->copy()->round()->toFloat());
        
        $number = Number::of(123456.999999999);
        $this->assertSame(123457.0, $number->copy()->round()->toFloat());
        
        $number = Number::of(123456.99);
        $this->assertSame(123457.0, $number->copy()->round()->toFloat());
        
        $number = Number::of(123456.499999999);
        $this->assertSame(123456.0, $number->copy()->round()->toFloat());
        
        $number = Number::of(123456.599999999);
        $this->assertSame(123457.0, $number->copy()->round()->toFloat());
        
        $number = Number::of(123456.512311199);
        $this->assertSame(123457.0, $number->copy()->round()->toFloat());
    }

    public function testRoundValueWithCustomDecimalsAndDefaultRoundingMode(): void
    {
        $number = Number::of(123456);
        $this->assertSame(123456.0, $number->round(1)->toFloat());
        $this->assertSame(123456.0, $number->round(2)->toFloat());
        $this->assertSame(123456.0, $number->round(9)->toFloat());
        
        $number = Number::of(123456.999999999);
        $this->assertSame(123457.0, $number->copy()->round(1)->toFloat());
        $this->assertSame(123457.0, $number->copy()->round(2)->toFloat());
        $this->assertSame(123456.999999999, $number->copy()->round(9)->toFloat());
        
        $number = Number::of(123456.99);
        $this->assertSame(123457.0, $number->copy()->round(1)->toFloat());
        $this->assertSame(123456.99, $number->copy()->round(2)->toFloat());
        $this->assertSame(123456.99, $number->copy()->round(9)->toFloat());
        
        $number = Number::of(123456.499999999);
        $this->assertSame(123456.5, $number->copy()->round(1)->toFloat());
        $this->assertSame(123456.5, $number->copy()->round(2)->toFloat());
        $this->assertSame(123456.499999999, $number->copy()->round(9)->toFloat());
        
        $number = Number::of(123456.599999999);
        $this->assertSame(123456.6, $number->copy()->round(1)->toFloat());
        $this->assertSame(123456.6, $number->copy()->round(2)->toFloat());
        $this->assertSame(123456.599999999, $number->copy()->round(9)->toFloat());
        
        $number = Number::of(123456.512311199);
        $this->assertSame(123456.5, $number->copy()->round(1)->toFloat());
        $this->assertSame(123456.51, $number->copy()->round(2)->toFloat());
        $this->assertSame(123456.5123112, $number->copy()->round(7)->toFloat());
        $this->assertSame(123456.5123112, $number->copy()->round(8)->toFloat());
        $this->assertSame(123456.512311199, $number->copy()->round(9)->toFloat());
    }

    public function testRoundValueWithDecimalsAndRoundingModeHalfUp(): void
    {
        $number = Number::of(123456);
        $this->assertSame(123456.0, $number->round(1, RoundingMode::HALF_UP)->toFloat());
        
        $number = Number::of(123456.5);
        $this->assertSame(123457.0, $number->copy()->round(0, RoundingMode::HALF_UP)->toFloat());
        $this->assertSame(123456.5, $number->copy()->round(1, RoundingMode::HALF_UP)->toFloat());
        
        $number = Number::of(123456.2);
        $this->assertSame(123456.0, $number->copy()->round(0, RoundingMode::HALF_UP)->toFloat());
        $this->assertSame(123456.2, $number->copy()->round(1, RoundingMode::HALF_UP)->toFloat());
        
        $number = Number::of(123456.6);
        $this->assertSame(123457.0, $number->copy()->round(0, RoundingMode::HALF_UP)->toFloat());
        $this->assertSame(123456.6, $number->copy()->round(1, RoundingMode::HALF_UP)->toFloat());
        
        $number = Number::of(123456.9);
        $this->assertSame(123457.0, $number->copy()->round(0, RoundingMode::HALF_UP)->toFloat());
        $this->assertSame(123456.9, $number->copy()->round(1, RoundingMode::HALF_UP)->toFloat());
    }

    public function testRoundValueWithRoundingModeHalfDown(): void
    {
        $number = Number::of(123456);
        $this->assertSame(123456.0, $number->round(1, RoundingMode::HALF_DOWN)->toFloat());
        
        $number = Number::of(123456.5);
        $this->assertSame(123456.0, $number->copy()->round(0, RoundingMode::HALF_DOWN)->toFloat());
        $this->assertSame(123456.5, $number->copy()->round(1, RoundingMode::HALF_DOWN)->toFloat());
        
        $number = Number::of(123456.2);
        $this->assertSame(123456.0, $number->copy()->round(0, RoundingMode::HALF_DOWN)->toFloat());
        $this->assertSame(123456.2, $number->copy()->round(1, RoundingMode::HALF_DOWN)->toFloat());
        
        $number = Number::of(123456.6);
        $this->assertSame(123457.0, $number->copy()->round(0, RoundingMode::HALF_DOWN)->toFloat());
        $this->assertSame(123456.6, $number->copy()->round(1, RoundingMode::HALF_DOWN)->toFloat());
        
        $number = Number::of(123456.9);
        $this->assertSame(123457.0, $number->copy()->round(0, RoundingMode::HALF_DOWN)->toFloat());
        $this->assertSame(123456.9, $number->copy()->round(1, RoundingMode::HALF_DOWN)->toFloat());
    }

    public function testRoundValueWithRoundingModeHalfEven(): void
    {        
        $number = Number::of(123456.5);
        $this->assertSame(123456.0, $number->copy()->round(0, RoundingMode::HALF_EVEN)->toFloat());
        $this->assertSame(123456.5, $number->copy()->round(1, RoundingMode::HALF_EVEN)->toFloat());
        
        $number = Number::of(123455.5);
        $this->assertSame(123456.0, $number->copy()->round(0, RoundingMode::HALF_EVEN)->toFloat());
        $this->assertSame(123455.5, $number->copy()->round(1, RoundingMode::HALF_EVEN)->toFloat());
        
        $number = Number::of(123455.2);
        $this->assertSame(123455.0, $number->copy()->round(0, RoundingMode::HALF_EVEN)->toFloat());
        $this->assertSame(123455.2, $number->copy()->round(1, RoundingMode::HALF_EVEN)->toFloat());
        
        $number = Number::of(123456.6);
        $this->assertSame(123457.0, $number->copy()->round(0, RoundingMode::HALF_EVEN)->toFloat());
        $this->assertSame(123456.6, $number->copy()->round(1, RoundingMode::HALF_EVEN)->toFloat());
        
        $number = Number::of(123456.9);
        $this->assertSame(123457.0, $number->copy()->round(0, RoundingMode::HALF_EVEN)->toFloat());
        $this->assertSame(123456.9, $number->copy()->round(1, RoundingMode::HALF_EVEN)->toFloat());
    }

    public function testRoundValueWithRoundingModeHalfOdd(): void
    {        
        $number = Number::of(123456.5);
        $this->assertSame(123457.0, $number->copy()->round(0, RoundingMode::HALF_ODD)->toFloat());
        $this->assertSame(123456.5, $number->copy()->round(1, RoundingMode::HALF_ODD)->toFloat());
        
        $number = Number::of(123455.5);
        $this->assertSame(123455.0, $number->copy()->round(0, RoundingMode::HALF_ODD)->toFloat());
        $this->assertSame(123455.5, $number->copy()->round(1, RoundingMode::HALF_ODD)->toFloat());
        
        $number = Number::of(123455.2);
        $this->assertSame(123455.0, $number->copy()->round(0, RoundingMode::HALF_ODD)->toFloat());
        $this->assertSame(123455.2, $number->copy()->round(1, RoundingMode::HALF_ODD)->toFloat());
        
        $number = Number::of(123456.6);
        $this->assertSame(123457.0, $number->copy()->round(0, RoundingMode::HALF_ODD)->toFloat());
        $this->assertSame(123456.6, $number->copy()->round(1, RoundingMode::HALF_ODD)->toFloat());
        
        $number = Number::of(123456.9);
        $this->assertSame(123457.0, $number->copy()->round(0, RoundingMode::HALF_ODD)->toFloat());
        $this->assertSame(123456.9, $number->copy()->round(1, RoundingMode::HALF_ODD)->toFloat());
    }
}