<?php

namespace Src\Helpers;

class Cookie
{
    /**
     * @param string $key
     * @param $value
     * @param int $time
     */
    public static function set(string $key, $value, $time = 31536000): void
    {
        if (is_array($value)) {
            $value = serialize($value);
        }

        setcookie($key, $value, time() + $time, '/');
    }

    /**
     * @param string $key
     * @return string|null
     */
    public static function get(string $key): ?string
    {
        return $_COOKIE[$key] ?? null;
    }

    /**
     * @param string $key
     * @param string|null $property
     * @return mixed|null
     */
    public static function getUnserialized(string $key, string $property = null)
    {
        $unserialized = unserialize(self::get($key));

        if ($unserialized !== false) {
            if ($unserialized !== null) {
                if ($property !== null) {
                    return array_key_exists($property, $unserialized) ? $unserialized[$property] : null;
                }

                return $unserialized;
            }
        }

        return null;
    }

    /**
     * @param string $key
     * @return bool
     */
    public static function has(string $key): bool
    {
        return isset($_COOKIE[$key]);
    }

    /**
     * @param string $key
     * @return bool
     */
    public static function unset(string $key): bool
    {
        if (!isset($_COOKIE[$key])) {
            return false;
        }

        self::set($key, '', time() - 3600);
        unset($_COOKIE[$key]);

        return true;
    }
}