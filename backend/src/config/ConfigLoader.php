<?php

namespace App\Config;

use App\Utils\PathManager;

class ConfigLoader
{
    public static function load($key)
    {
        $file = PathManager::getPath($key);

        if (!file_exists($file)) {
            throw new \Exception("Config file not found: $file");
        }

        return json_decode(file_get_contents($file), true);
    }
}