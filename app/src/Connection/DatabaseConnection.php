<?php

namespace App\Connection;

use App\Config\DatabaseConfig;
use App\Utilities\ServiceLocator;
use PDO;

class DatabaseConnection
{
    /**
     * @var DatabaseConnection|null Singleton instance of the Connection class
     */
    private static $instance = null;

    /**
     * @var PDO Database connection
     */
    private $conn;

    /**
     * Connection constructor.
     * Private to prevent multiple instances.
     * Initializes a PDO connection.
     */
     private function __construct(DatabaseConfig $config)
    {
        $dataSource = "mysql:host=" . $config['host'] . ";dbname=" . $config['dbname'];
        $this->conn = new PDO($dataSource, $config['username'], $config['password']);
    }

    /**
     * Get the singleton instance of the Connection class.
     * If it doesn't exist, a new instance is created.
     *
     * @return DatabaseConnection Singleton instance of the Connection class
     */
     public static function getInstance()
    {
        if (self::$instance === null) {
            $config = ServiceLocator::get('DatabaseConfig');
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    /**
     * Get the PDO connection.
     *
     * @return PDO Database connection
     */
    public function getConnection()
    {
        return $this->conn;
    }
}
