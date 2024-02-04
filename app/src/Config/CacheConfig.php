<?php

namespace App\Config;

use App\Utilities\Errors\ErrorCode;
use App\Utilities\Exceptions\CacheException;

class CacheConfig
{
    const SUBSCRIBER_EMAIL_KEY = 'sub_email:';

    private $config;

    public function __construct($type = 'redis')
    {
        $config = [
            'redis' => [
                'host' => 'REDIS_HOST',
                'port' => 'REDIS_PORT',
                'password' => 'REDIS_PASSWORD',
            ],
        ];

        if (!array_key_exists($type, $config)) {
            throw new CacheException(
                sprintf(ErrorCode::CACHE_NOT_SUPPORTED['message'], $type),
                500
            );
        }

        $this->config = array_map(function ($value) {
            return getenv($value) ?: null;
        }, $config[$type]);
    }

    public function getConfig()
    {
        return $this->config;
    }
}
