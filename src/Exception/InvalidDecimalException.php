<?php

namespace Number\Exception;

use Exception;

class InvalidDecimalException extends Exception
{
    public static function invalidValue(?string $value): self
    {
        return new self("The value provided is not a possible integer value: {$value}.");
    }

    public static function invalidTypeCast(mixed $value): self
    {
        return new self('The value provided does not match with the allowed type. Expect: string|float|int, Receive: ' . gettype($value) . '.');
    }
}