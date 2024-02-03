<?php

namespace App\Config;

use App\Utilities\Exceptions\DatabaseException;

class DatabaseConfig
{
    private static $config = [
        'mysql' => [
            'host' => 'MYSQL_HOST',
            'dbname' => 'MYSQL_DBNAME',
            'username' => 'MYSQL_USERNAME',
            'password' => 'MYSQL_PASSWORD',
            'port' => 'MYSQL_PORT',
        ],
    ];

    public static function getConfig($type = 'mysql')
    {
        if (!array_key_exists($type, self::$config)) {
            throw new DatabaseException("Database type {$type} is not supported.", 500);
        }

        return array_map(function ($value) {
            return getenv($value) ?: 'default';
        }, self::$config[$type]);
    }
}
