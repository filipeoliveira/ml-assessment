<?php

namespace Tests;

use App\Config\DatabaseConfig;
use App\Utilities\Errors\ErrorCode;
use App\Utilities\Exceptions\DatabaseException;
use PHPUnit\Framework\TestCase;

class DatabaseConfigTest extends TestCase
{
    public function testGetConfig()
    {
        $databaseConfig = new DatabaseConfig();
        $config = $databaseConfig->getConfig();

        $this->assertIsArray($config);
        $this->assertArrayHasKey('host', $config);
        $this->assertArrayHasKey('dbname', $config);
        $this->assertArrayHasKey('username', $config);
        $this->assertArrayHasKey('password', $config);
        $this->assertArrayHasKey('port', $config);
    }

    public function testGetConfigWithInvalidType()
    {
        $this->expectException(DatabaseException::class);
        $this->expectExceptionMessage(sprintf(ErrorCode::DATABASE_NOT_SUPPORTED['message'], 'invalid'));

        $databaseConfig = new DatabaseConfig('invalid');
    }
}