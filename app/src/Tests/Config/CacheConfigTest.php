<?php

namespace Tests\Config;

use App\Config\CacheConfig;
use App\Utilities\Exceptions\CacheException;
use PHPUnit\Framework\TestCase;

class CacheConfigTest extends TestCase
{
    public function testGetConfig()
    {
        $config = CacheConfig::getConfig();

        $this->assertIsArray($config);
        $this->assertArrayHasKey('host', $config);
        $this->assertArrayHasKey('port', $config);
        $this->assertArrayHasKey('password', $config);
    }

    public function testGetConfigWithInvalidType()
    {
        $this->expectException(CacheException::class);
        $this->expectExceptionMessage('Cache type invalid is not supported.');

        CacheConfig::getConfig('invalid');
    }
}