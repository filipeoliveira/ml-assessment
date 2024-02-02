<?php

namespace App\Config;

return array(
    'host' => getenv('CACHE_HOST') ?: '127.0.0.1',
    'port' => getEnv('CACHE_PORT') ?: '6379',
    'username' => getenv('DB_USERNAME') ?: null,
    'password' => getenv('DB_PASSWORD') ?: null
);