<?php

namespace App\Utilities\Errors;

class ErrorCode
{

    const SUBSCRIBER_NOT_FOUND = [
        'message' => 'Subscriber not found'
    ];

    const SUBSCRIBER_ALREADY_EXISTS = [
        'message' => 'Subscriber already exists'
    ];

    const MISSING_VALUE = [
        'message' => 'The %s is required and was not provided.'
    ];

    const NOT_STRING = [
        'message' => 'The %s must be a string'
    ];

    const INVALID_EMAIL = [
        'message' => 'Invalid email'
    ];

    const LENGTH_EXCEEDED = [
        'message' => 'The %s exceeds the maximum allowed length'
    ];

    const CACHE_NOT_SUPPORTED = [
        'message' => 'Cache type %s is not supported.'
    ];

    const DATABASE_NOT_SUPPORTED = [
        'message' => 'Database type %s is not supported.'
    ];
}
