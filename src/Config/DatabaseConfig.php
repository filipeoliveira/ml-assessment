<?php

namespace App\Config;

return array(
    'host' => getenv('DB_HOST') ?: 'localhost',
    'dbname' => getenv('DB_NAME') ?: 'default',
    'username' => getenv('DB_USERNAME') ?: 'default_username',
    'password' => getenv('DB_PASSWORD') ?: 'defaul_password'
);