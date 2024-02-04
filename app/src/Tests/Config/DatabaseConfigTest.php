<?php

namespace Tests\Config;

use App\Config\DatabaseConfig;
use App\Utilities\Exceptions\DatabaseException;
use PHPUnit\Framework\TestCase;

class DatabaseConfigTest extends TestCase
{
    public function testGetConfig()
    {
        $config = DatabaseConfig::getConfig();

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
        $this->expectExceptionMessage('Database type invalid is not supported.');

        DatabaseConfig::getConfig('invalid');
    }
}
