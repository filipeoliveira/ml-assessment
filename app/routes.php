<?php

/**
 * This file defines the routes for the application.
 * Each route is mapped to a controller and a method within that controller.
 */

use App\Controllers\SubscriberController;
use Pimple\Container;
use App\Utilities\Http;

class Router
{
    private $routes = [];
    private $container;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function handleRequest()
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $path = trim($path, '/');
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route => $handlers) {
            $routePattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $route);

            if (preg_match('#^' . $routePattern . '$#', $path, $matches)) {
                array_shift($matches);

                if (isset($handlers[$method])) {
                    $handler = $handlers[$method];

                    if (is_array($handler)) {
                        list($class, $method) = $handler;
                        $controller = $this->container[$class];
                        call_user_func_array([$controller, $method], $matches);
                    } else if ($handler instanceof Closure) {
                        call_user_func_array($handler, $matches);
                    }

                    return;
                }
            }
        }

        // No route matched
        http_response_code(404);
        echo "Not found";
    }

    public function setContainer(Container $container)
    {
        $this->container = $container;
    }
}

return new Router([
    'api/subscribers' => [
        'GET' => [SubscriberController::class, 'getAll'],
        'POST' => [SubscriberController::class, 'create'],
    ],
    'api/subscribers/{email}' => [
        'GET' => [SubscriberController::class, 'getByEmail'],
    ],
    'api/health' => [
        'GET' => function () {
            $http = new Http();
            $http->response("OK", 200);
        },
    ]
]);
