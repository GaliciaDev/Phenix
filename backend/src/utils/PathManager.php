<?php

namespace App\Utils;

class PathManager
{
    protected static $paths = [];

    public static function setPath($key, $path)
    {
        self::$paths[$key] = $path;
    }

    public static function getPath($key)
    {
        if (!isset(self::$paths[$key])) {
            throw new \Exception("Path not found: $key");
        }

        return self::$paths[$key];
    }
}