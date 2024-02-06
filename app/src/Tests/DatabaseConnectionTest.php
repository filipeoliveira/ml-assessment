<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Connection\DatabaseConnection;
use App\Config\DatabaseConfig;
use PDO;

class DatabaseConnectionTest extends TestCase
{
    public function testConstructor()
    {
        $config = $this->createMock(DatabaseConfig::class);
        $config->method('getConfig')->willReturn(
            [
            'host' => 'localhost',
            'dbname' => 'test',
            'username' => 'root',
            'password' => 'password',
            ]
        );

        $pdoStub = $this->createStub(PDO::class);
        $dbConnection = new DatabaseConnection($config, $pdoStub);

        $this->assertInstanceOf(DatabaseConnection::class, $dbConnection);
    }

    public function testGetConnection()
    {
        $config = $this->createMock(DatabaseConfig::class);
        $config->method('getConfig')->willReturn(
            [
            'host' => 'localhost',
            'dbname' => 'test',
            'username' => 'root',
            'password' => 'password',
            ]
        );

        $pdoStub = $this->createStub(PDO::class);
        $dbConnection = new DatabaseConnection($config, $pdoStub);

        $this->assertInstanceOf(PDO::class, $dbConnection->getConnection());
    }
}
