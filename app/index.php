<?php

/**
 * This file is the entry point for the application.
 * It sets up error handling, loads the routes, and dispatches the request.
 */

require_once __DIR__ . '/src/setup.php';

use App\BootstrapContainer;

// Load the routes
$bootstrap = new BootstrapContainer();
$container = $bootstrap->getContainer();
$router = require_once "routes.php";

$router->setContainer($container);
$router->handleRequest();
