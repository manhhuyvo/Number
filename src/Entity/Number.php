<?php

namespace ManhHuyVo\Number\Entity;

use ManhHuyVo\Number\Constant\RoundingMode;
use ManhHuyVo\Number\Exception\InvalidDecimalException;
use ManhHuyVo\Number\Exception\InvalidOperationException;
use ManhHuyVo\Number\Exception\InvalidRoundingModeException;
use ManhHuyVo\Number\Exception\InvalidValueException;
use ManhHuyVo\Number\Exception\InvalidScaleException;

class Number
{
    public function __construct(protected float $value)
    {        
    }

    public static function of(string|float|int|null $value): self
    {
        return new self(self::sanitizeValue($value));
    }

    public static function setGlobalScale(string|float|int|null $scale): void
    {
        bcscale(self::sanitizeScale($scale));
    }

    /** VALUE-RELATED OPERATIONS */

    public function setValue(string|float|int|null $value): self
    {
        $this->value = self::sanitizeValue($value);

        return $this;
    }

    public function toFloat(): float
    {
        return (float) $this->value;
    }

    public function toString(): string
    {
        return (float) $this->value;
    }

    public function toInt(): int
    {
        return (int) $this->value;
    }

    public function absolute(): self
    {
        return $this->setValue(abs($this->toFloat()));
    }

    /** FORMAT OPERATIONS */

    public function numberFormat(string|float|int|null $decimal, ?string $decimalSeparator = '.', ?string $thousandsSeparator = ','): string
    {
        return number_format($this->toFloat(), self::sanitizeDecimal($decimal), $decimalSeparator, $thousandsSeparator);
    }

    public function round(string|float|int|null $decimal, string|int|null $roundingMode): self
    {
        $decimal = self::sanitizeDecimal($decimal);
        $roundingMode = self::sanitizeRoundingMode($roundingMode);

        return $this->setValue(round($this->toFloat(), $decimal, $roundingMode));
    }

    /** MATH OPERATIONS */

    public function plus(self|string|float|int|null $number, string|float|int|null $scale): self
    {
        if (! $number instanceof self) {
            $number = self::of($number);
        }

        return $this->setValue(bcadd($this->toString(), $number->toString()), self::sanitizeScale($scale));
    }

    public function minus(self|string|float|int|null $number, string|float|int|null $scale): self
    {
        if (! $number instanceof self) {
            $number = self::of($number);
        }

        return $this->setValue(bcsub($this->toString(), $number->toString()), self::sanitizeScale($scale));
    }

    public function multiply(self|string|float|int|null $number, string|float|int|null $scale): self
    {
        if (! $number instanceof self) {
            $number = self::of($number);
        }

        return $this->setValue(bcmul($this->toString(), $number->toString()), self::sanitizeScale($scale));
    }

    public function divide(self|string|float|int|null $number, string|float|int|null $scale): self
    {
        if (! $number instanceof self) {
            $number = self::of($number);
        }

        if ($number->isZero()) {
            throw InvalidOperationException::dividedByZero();
        }

        return $this->setValue(bcdiv($this->toString(), $number->toString()), self::sanitizeScale($scale));
    }

    /** COMPARATIVE OPERATIONS */

    public function lessThan(self|string|float|int|null $number): bool
    {
        if (! $number instanceof self) {
            $number = self::of($number);
        }

        return $this->toFloat() < $number->toFloat();
    }

    public function lessThanOrEqual(self|string|float|int|null $number): bool
    {
        if (! $number instanceof self) {
            $number = self::of($number);
        }

        return $this->toFloat() <= $number->toFloat();
    }

    public function greaterThan(self|string|float|int|null $number): bool
    {
        if (! $number instanceof self) {
            $number = self::of($number);
        }

        return $this->toFloat() > $number->toFloat();
    }

    public function greaterThanOrEqual(self|string|float|int|null $number): bool
    {
        if (! $number instanceof self) {
            $number = self::of($number);
        }

        return $this->toFloat() >= $number->toFloat();
    }

    public function equal(self|string|float|int|null $number): bool
    {
        if (! $number instanceof self) {
            $number = self::of($number);
        }

        return $this->toFloat() === $number->toFloat();
    }

    /** ZERO OPERATIONS */

    public function isZero(): bool
    {
        return $this->toInt() === 0;
    }

    public static function zero(): self
    {
        return new self(0);
    }

    /** SANITIZE OPERATIONS */

    private static function sanitizeScale(string|float|int|null $scale): int
    {
        if (empty($scale)) {
            return 0;
        }

        if (!is_numeric($scale)) {
            throw InvalidScaleException::invalidValue($scale);
        }

        if (!in_array(gettype($scale), ['string', 'float', 'int'])) {
            throw InvalidScaleException::invalidTypeCast($scale);
        }

        return (int) $scale;
    }

    private static function sanitizeValue(string|float|int|null $value): float
    {
        if (empty($value)) {
            return 0.00;
        }

        if (!is_numeric($value)) {
            throw InvalidValueException::invalidValue($value);
        }

        if (!in_array(gettype($value), ['string', 'float', 'int', 'null'])) {
            throw InvalidValueException::invalidTypeCast($value);
        }

        return (float) $value;
    }

    private static function sanitizeDecimal(string|float|int|null $decimal): int
    {
        if (empty($decimal)) {
            return 0;
        }

        if (!is_numeric($decimal)) {
            throw InvalidDecimalException::invalidValue($decimal);
        }

        if (!in_array(gettype($decimal), ['string', 'float', 'int'])) {
            throw InvalidDecimalException::invalidTypeCast($decimal);
        }

        return (int) $decimal;
    }

    private static function sanitizeRoundingMode(string|int|null $roundingMode): int
    {
        if (empty($roundingMode)) {
            return PHP_ROUND_HALF_UP;
        }

        if (! is_numeric($roundingMode)) {
            throw InvalidRoundingModeException::invalidValue($roundingMode);
        }

        if (! in_array(gettype($roundingMode), ['string', 'int', 'null'])) {
            throw InvalidRoundingModeException::invalidTypeCast($roundingMode);
        }

        if (! RoundingMode::isValid((int) $roundingMode)) {
            throw InvalidRoundingModeException::invalidAvailableValue($roundingMode);
        }

        return (int) $roundingMode;
    }
}