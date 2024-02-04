<?php

namespace App\Utilities;

use Exception;

class ServiceLocator
{
    private static $services = [];

    public static function register($name, $service)
    {
        self::$services[$name] = $service;
    }

    public static function get($name)
    {
        if (!isset(self::$services[$name])) {
            throw new Exception("Service not found: $name");
        }

        return self::$services[$name];
    }
}
