<?php

require_once 'vendor/autoload.php';
require_once 'src/helpers.php';
require_once 'src/Utilities/ErrorHandler.php';

use App\Utilities\Errors\ErrorHandler;

// TODO - check this file later on to refactor it.

// Get the HTTP method and path of the request
$method = $_SERVER['REQUEST_METHOD'];
$path = trim($_SERVER['PATH_INFO'], '/');


// Initialize error Handler
new ErrorHandler();

// Load the routes
$routes = require 'routes.php';

// Check if the route and method exist in the routes array
if (isset($routes[$path][$method])) {
    // Get the controller and method
    [$controllerClass, $method] = $routes[$path][$method];

    // Create a new instance of the controller and call the method
    $controller = new $controllerClass();
    $controller->$method();
} else {
    // Send a 404 Not Found response if the route or method is not defined
    header('HTTP/1.1 404 Not Found');
}
