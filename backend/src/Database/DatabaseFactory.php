<?php

namespace App\Database;

use App\Config\ConfigLoader;

class DatabaseFactory
{
    protected static $types = [];

    public static function register($type, $class)
    {
        self::$types[$type] = $class;
    }

    public static function create($type)
    {
        if (!isset(self::$types[$type])) {
            throw new DatabaseException("Unsupported database type: $type");
        }

        $config = ConfigLoader::load('database');

        return new self::$types[$type]($config[$type]);
    }
}
