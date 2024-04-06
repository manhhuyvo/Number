<?php

namespace ManhHuyVo\Number\Exception;

use Exception;
use ManhHuyVo\Number\Constant\RoundingMode;

class InvalidRoundingModeException extends Exception
{
    public static function invalidValue(?string $value): self
    {
        return new self("The value provided is not a possible integer value: {$value}.");
    }

    public static function invalidTypeCast(mixed $value): self
    {
        return new self('The value provided does not match with the allowed type. Expect: string|int|null, Receive: ' . gettype($value) . '.');
    }

    public function invalidAvailableValue(?string $value): self
    {
        return new self('The value provided is not accepted. Expect: ' . implode('|', RoundingMode::getAll()) . ", Receive: {$value}.");
    }
}