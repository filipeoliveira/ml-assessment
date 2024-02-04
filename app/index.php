<?php

/**
 * This file is the entry point for the application.
 * It sets up error handling, loads the routes, and dispatches the request.
 */

require_once 'src/Utilities/Errors/ErrorHandler.php';

use App\Utilities\Errors\ErrorHandler;

new ErrorHandler();

// Load the routes
$container = require_once __DIR__ . '/src/bootstrap.php';
$router = require_once "routes.php";


$router->setContainer($container);
$router->handleRequest();
