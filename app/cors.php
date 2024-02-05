<?php

// Get the origin of the request
$origin = $_SERVER['HTTP_ORIGIN'];

// Check if the origin is allowed
// Frontend-app is the frontend docker name
// localhost:8085 is the default localhost configuration.
$allowed_origins = ['http://frontend-app', 'http://localhost:8085'];
if (in_array($origin, $allowed_origins)) {
    header('Access-Control-Allow-Origin: ' . $origin);
}

header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
