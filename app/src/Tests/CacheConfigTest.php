<?php

namespace Tests;

use App\Config\CacheConfig;
use App\Utilities\Errors\ErrorCode;
use App\Utilities\Exceptions\CacheException;
use PHPUnit\Framework\TestCase;


class CacheConfigTest extends TestCase
{
    public function testGetConfig()
    {
        $cacheConfig = new CacheConfig();
        $config = $cacheConfig->getConfig();

        $this->assertIsArray($config);
        $this->assertArrayHasKey('host', $config);
        $this->assertArrayHasKey('port', $config);
        $this->assertArrayHasKey('password', $config);
    }

    public function testGetConfigWithInvalidType()
    {
        $this->expectException(CacheException::class);
        $this->expectExceptionMessage(sprintf(ErrorCode::CACHE_NOT_SUPPORTED['message'], 'invalid'));
    
        $cacheConfig = new CacheConfig('invalid');
    }
}