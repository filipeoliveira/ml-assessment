<?php

namespace App\Connection;

use Predis\Client as Predis;
use App\Config\CacheConfig;

class CacheConnection
{
    /**
     * @var Redis Cache connection
     */
    private $conn;

    /**
     * CacheConnection constructor.
     * Private to prevent multiple instances.
     * Initializes a Redis connection.
     */
    public function __construct(CacheConfig $config, Predis $predis = null)
    {
        if ($predis !== null) {
            $this->conn = $predis;
        } else {
            $config = $config->getConfig();
            $this->conn = new Predis(
                [
                    'scheme' => 'tcp',
                    'host'   => $config['host'],
                ]
            );
            if (isset($config['password'])) {
                $this->conn->auth($config['password']);
            }
        }
    }

    /**
     * Get the Redis connection.
     *
     * @return Redis Cache connection
     */
    public function getConnection()
    {
        return $this->conn;
    }
}
