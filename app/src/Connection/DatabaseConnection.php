<?php

namespace App\Connection;

use App\Config\DatabaseConfig;
use PDO;

class DatabaseConnection
{
    /**
     * @var Connection|null Singleton instance of the Connection class
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
    private function __construct()
    {
        $config = DatabaseConfig::getConfig()['mysql'];
        $dataSource = "mysql:host=" . $config['host'] . ";dbname=" . $config['dbname'];
        $this->conn = new PDO($dataSource, $config['username'], $config['password']);
    }

    /**
     * Get the singleton instance of the Connection class.
     * If it doesn't exist, a new instance is created.
     *
     * @return Connection Singleton instance of the Connection class
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new DatabaseConnection();
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
