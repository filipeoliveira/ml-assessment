<?php

namespace App\Connection;

use App\Config\DatabaseConfig;
use PDO;

class DatabaseConnection
{
    /**
     * @var PDO Database connection
     */
    private $conn;

    /**
     * Connection constructor.
     * Initializes a PDO connection.
     */
    public function __construct(DatabaseConfig $config, PDO $pdo = null)
    {
        if ($pdo !== null) {
            $this->conn = $pdo;
        } else {
            $config = $config->getConfig();
            $dataSource = "mysql:host=" . $config['host'] . ";dbname=" . $config['dbname'];
            $this->conn = new PDO($dataSource, $config['username'], $config['password']);
        }
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