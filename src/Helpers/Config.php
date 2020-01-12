<?php

namespace Src\Helpers;

use Src\Exceptions\FileNotFoundException;

class Config
{
    /**
     * @param string $path
     * @param string $ext
     * @return mixed
     * @throws FileNotFoundException
     */
    public static function get(string $path, string $ext = '.php')
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/../src/Configs/' . $path . $ext;

        if (!file_exists($path)) {
            throw new FileNotFoundException('Config file not found in provided path ' . $path);
        }

        return require $path;
    }
}