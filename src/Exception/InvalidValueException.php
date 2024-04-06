<?php

namespace ManhHuyVo\Number\Exception;

use Exception;

class InvalidValueException extends Exception
{
    public static function invalidValue(?string $value): self
    {
        return new self("The value provided is not a possible numeric value: {$value}.");
    }

    public static function invalidTypeCast(mixed $value): self
    {
        return new self('The value provided does not match with the allowed type. Expect: string|float|int|null, Receive: ' . gettype($value) . '.');
    }
}