<?php

namespace App\Config;

use App\Utilities\Exceptions\CacheException;

class CacheConfig
{
    const SUBSCRIBER_EMAIL_KEY = 'sub_email:';

    private static $config = [
        'redis' => [
            'host' => 'REDIS_HOST',
            'port' => 'REDIS_PORT',
            'password' => 'REDIS_PASSWORD',
        ],
    ];

    public static function getConfig($type = 'redis')
    {
        if (!array_key_exists($type, self::$config)) {
            throw new CacheException("Cache type {$type} is not supported.", 500);
        }

        return array_map(function ($value) {
            return getenv($value) ?: null;
        }, self::$config[$type]);
    }
}
