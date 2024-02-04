<?php

namespace App\Connection;

use Predis\Client as Predis;
use App\Utilities\ServiceLocator;
use App\Config\CacheConfig;

class CacheConnection
{
    /**
     * @var CacheConnection|null Singleton instance of the CacheConnection class
     */
    private static $instance = null;

    /**
     * @var Redis Cache connection
     */
    private $conn;

    /**
     * CacheConnection constructor.
     * Private to prevent multiple instances.
     * Initializes a Redis connection.
     */
    private function __construct(CacheConfig $config)
    {
        $this->conn = new Predis([
            'scheme' => 'tcp',
            'host'   => $config['host'],
        ]);
        if (isset($config['password'])) {
            $this->conn->auth($config['password']);
        }
    }

    /**
     * Get the singleton instance of the CacheConnection class.
     * If it doesn't exist, a new instance is created.
     *
     * @return CacheConnection Singleton instance of the CacheConnection class
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            $config = ServiceLocator::get('CacheConfig');
            self::$instance = new self($config);
        }
        return self::$instance;
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
