<?php

use PHPUnit\Framework\TestCase;
use Predis\Client as Predis;

use App\Config\CacheConfig;
use App\Connection\CacheConnection;

class CacheConnectionTest extends TestCase
{
    public function testConstructor()
    {
        $config = $this->createMock(CacheConfig::class);
        $config->method('getConfig')->willReturn([
            'host' => 'localhost',
            'password' => 'password',
        ]);

        $predisStub = $this->createStub(Predis::class);
        $cacheConnection = new CacheConnection($config, $predisStub);

        $this->assertInstanceOf(CacheConnection::class, $cacheConnection);
    }

    public function testGetConnection()
    {
        $config = $this->createMock(CacheConfig::class);
        $config->method('getConfig')->willReturn([
            'host' => 'localhost',
            'password' => 'password',
        ]);

        $predisStub = $this->createStub(Predis::class);
        $cacheConnection = new CacheConnection($config, $predisStub);

        $this->assertInstanceOf(Predis::class, $cacheConnection->getConnection());
    }
}
