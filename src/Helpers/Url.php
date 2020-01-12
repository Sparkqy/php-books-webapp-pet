<?php

namespace Src\Helpers;

class Url
{
    /**
     * @return string
     */
    public static function getRequestMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return string
     */
    public static function getUrl(): string
    {
        $url = $_SERVER['REQUEST_URI'];
        $position = strpos($url, '?');

        return ($position) ? substr($url, 0, $position) : $url;
    }
}