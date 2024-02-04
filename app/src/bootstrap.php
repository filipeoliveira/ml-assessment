<?php

namespace App;

use Pimple\Container;
use App\Utilities\Http;
use App\Config\DatabaseConfig;
use App\Config\CacheConfig;
use App\Services\SubscriberService;
use App\Connection\CacheConnection;
use App\Connection\DatabaseConnection;
use App\Repositories\SubscriberRepository;
use App\Controllers\SubscriberController;

class BootstrapContainer
{
    private $container;

    public function __construct()
    {
        $container = new Container();

        $container[DatabaseConfig::class] = function ($c) {
            return new DatabaseConfig();
        };

        $container[CacheConfig::class] = function ($c) {
            return new CacheConfig();
        };

        $container[DatabaseConnection::class] = function ($c) {
            $config = $c[DatabaseConfig::class];
            return new DatabaseConnection($config);
        };

        $container[CacheConnection::class] = function ($c) {
            $config = $c[CacheConfig::class];
            return new CacheConnection($config);
        };

        $container[SubscriberRepository::class] = function ($c) {
            return new SubscriberRepository($c[DatabaseConnection::class], $c[CacheConnection::class]);
        };

        $container[SubscriberService::class] = function ($c) {
            return new SubscriberService($c[SubscriberRepository::class]);
        };

        $container[Http::class] = function ($c) {
            return new Http();
        };

        $container[SubscriberController::class] = function ($c) {
            return new SubscriberController($c[Http::class], $c[SubscriberService::class]);
        };

        $this->container = $container;
    }

    public function getContainer()
    {
        return $this->container;
    }
}
