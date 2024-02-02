<?php

namespace App\Config;

return array(
    'redis' => array(
        'host' => getenv('REDIS_HOST') ?: '127.0.0.1',
        'port' => getenv('REDIS_PORT') ?: '6379',
        'username' => getenv('REDIS_USERNAME') ?: null,
        'password' => getenv('REDIS_PASSWORD') ?: null
    ),
);