<?php

namespace Number\Exception;

use Exception;

class InvalidOperationException extends Exception
{
    public static function dividedByZero(): self
    {
        return new self("Invalid operation: Divided by zero");
    }
}