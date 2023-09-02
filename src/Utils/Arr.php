<?php

declare(strict_types=1);
/**
 * This file is part of msmm.
 */

namespace Msmm\MtMtz\Utils;

/**
 * Most of the methods in this file come from illuminate/collections,
 * thanks Laravel Team provide such a useful class.
 */
class Arr
{
    /**
     * Determine whether the given value is array accessible.
     * @param mixed $value
     */
    public static function accessible($value): bool
    {
        return is_array($value) || $value instanceof \ArrayAccess;
    }

    /**
     * Determine if the given key exists in the provided array.
     * @param mixed $array
     * @param mixed $key
     */
    public static function exists($array, $key): bool
    {
        if ($array instanceof \ArrayAccess) {
            return $array->offsetExists($key);
        }
        return array_key_exists($key, $array);
    }

    /**
     * Get an item from an array using "dot" notation.
     * @param mixed $array
     * @param null|mixed $key
     * @param null|mixed $default
     */
    public static function get($array, $key = null, $default = null)
    {
        if (!static::accessible($array)) {
            return self::value($default);
        }
        if (is_null($key)) {
            return $array;
        }
        if (static::exists($array, $key)) {
            return $array[$key];
        }
        if (!is_string($key) || !str_contains($key, '.')) {
            return $array[$key] ?? self::value($default);
        }
        foreach (explode('.', $key) as $segment) {
            if (static::accessible($array) && static::exists($array, $segment)) {
                $array = $array[$segment];
            } else {
                return self::value($default);
            }
        }
        return $array;
    }

    public static function value($value, ...$args)
    {
        return $value instanceof \Closure ? $value(...$args) : $value;
    }
}
