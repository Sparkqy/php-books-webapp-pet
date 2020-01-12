<?php

namespace Src\Helpers;

use Src\Exceptions\FileNotFoundException;

class Router
{
    /**
     * @param string $path
     * @return array
     * @throws FileNotFoundException
     */
    public static function getRoutes(string $path): array
    {
        if (!file_exists($path)) {
            throw new FileNotFoundException('File does not exist on provided path');
        }

        return require_once $path;
    }

    /**
     * @param string $location
     */
    public static function redirect(string $location): void
    {
        header('Location: ' . $location);
        exit;
    }

    /**
     * @param string $sessionKey
     * @param array $sessionValue
     * @param string $redirectPath
     */
    public static function redirectWithFlash(string $sessionKey, array $sessionValue, string $redirectPath): void
    {
        Session::set($sessionKey, $sessionValue);
        self::redirect($redirectPath);
    }
}