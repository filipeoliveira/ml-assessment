<?php

use App\Config\DatabaseConfig;
use App\Config\CacheConfig;
use App\Services\SubscriberService;
use App\Connection\CacheConnection;
use App\Connection\DatabaseConnection;
use App\Repositories\SubscriberRepository;
use App\Controllers\SubscriberController;
use Pimple\Container;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/Utilities/HttpHelper.php';

// Set up the service container
$container = new Container();

$container[DatabaseConfig::class] = function ($c) {
    return new DatabaseConfig();
};

$container[CacheConfig::class] = function ($c) {
    return new CacheConfig();
};

$container['subscriberRepository'] = function ($c) {
    return new SubscriberRepository(
        DatabaseConnection::getInstance($c[DatabaseConfig::class]),
        CacheConnection::getInstance($c[CacheConfig::class])
    );
};

// Register the SubscriberService in the container
$container['subscriberService'] = function ($c) {
    return new SubscriberService($c['subscriberRepository']);
};

// Register the SubscriberController in the container
$container[SubscriberController::class] = function ($c) {
    return new SubscriberController($c);
};

return $container;