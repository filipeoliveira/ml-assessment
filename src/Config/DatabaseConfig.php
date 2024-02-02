<?php

namespace App\Config;

return array(
    'mysql' => array(
        'host' => getenv('MYSQL_HOST') ?: 'localhost',
        'dbname' => getenv('MYSQL_DBNAME') ?: 'default',
        'username' => getenv('MYSQL_USERNAME') ?: 'default_username',
    'password' => getenv('MYSQL_PASSWORD') ?: 'default_password',
        'port' => getenv('MYSQL_PORT') ?: '3306',
    ),
);