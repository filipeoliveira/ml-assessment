<?php

namespace App\Config;


use App\Utilities\Errors\ErrorCode;
use App\Utilities\Exceptions\DatabaseException;

class DatabaseConfig
{
    private $config;

    public function __construct($type = 'mysql')
    {
        $config = [
            'mysql' => [
                'host' => 'MYSQL_HOST',
                'dbname' => 'MYSQL_DBNAME',
                'username' => 'MYSQL_USERNAME',
                'password' => 'MYSQL_PASSWORD',
                'port' => 'MYSQL_PORT',
            ],
        ];

        if (!array_key_exists($type, $config)) {
            throw new DatabaseException(
                sprintf(ErrorCode::DATABASE_NOT_SUPPORTED['message'], $type),
                500);
        }

        $this->config = array_map(function ($value) {
            return getenv($value) ?: 'default';
        }, $config[$type]);
    }

    public function getConfig()
    {
        return $this->config;
    }
}
