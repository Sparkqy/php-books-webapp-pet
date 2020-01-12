<?php

namespace Src\Helpers;

class Session
{
    /**
     * @param string $key
     * @param array $value
     */
    public static function set(string $key, array $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @param string $property
     * @return mixed|null
     */
    public static function get(string $key, string $property = null)
    {
        if ($property !== null) {
            return (isset($_SESSION[$key][$property])) ? $_SESSION[$key][$property] : null;
        }

        return (isset($_SESSION[$key])) ? $_SESSION[$key] : null;
    }

    /**
     * @param string $key
     * @return bool
     */
    public static function has(string $key): bool
    {
        return (isset($_SESSION[$key]));
    }

    /**
     * @param string $key
     * @param string $property
     * @param boolean $unset
     * @return string
     */
    public static function flash(string $key, string $property, bool $unset = true): string
    {
        $message = (isset($_SESSION[$key][$property])) ? $_SESSION[$key][$property] : '';

        if ($unset) {
            unset($_SESSION[$key]);
        }

        return $message;
    }
}