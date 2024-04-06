<?php

namespace ManhHuyVo\Number\Constant;

final class RoundingMode
{
    public const HALF_UP = PHP_ROUND_HALF_UP;

    public const HALF_DOWN = PHP_ROUND_HALF_DOWN;

    public const HALF_EVEN = PHP_ROUND_HALF_EVEN;

    public const HALF_ODD = PHP_ROUND_HALF_ODD;

    public static function getAll()
    {
        return [
            self::HALF_UP,
            self::HALF_DOWN,
            self::HALF_EVEN,
            self::HALF_ODD,
        ];
    }

    public static function isValid(int $value): bool
    {
        return in_array($value, self::getAll());
    }
}