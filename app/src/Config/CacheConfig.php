<?php

/**
 * Cache Configuration
 *
 * @category Configuration
 * @package  App\Config
 */

namespace App\Config;

use App\Utilities\Errors\ErrorCode;
use App\Utilities\Exceptions\CacheException;

/**
 * CacheConfig Class
 *
 * @category Configuration
 * @package  App\Config
 */
class CacheConfig
{
    const SUBSCRIBER_EMAIL_KEY = 'sub_email:';

    /**
     * @var array Configuration array
     */
    private $config;

    /**
     * Constructor
     *
     * @param string $type Type of cache
     */
    public function __construct(string $type = 'redis')
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

        $this->config = array_map(
            function ($value) {
                return getenv($value) ?: null;
            },
            $config[$type]
        );
    }

    /**
     * Get Config
     *
     * @return array Configuration array
     */
    public function getConfig(): array
    {
        return $this->config;
    }
}
