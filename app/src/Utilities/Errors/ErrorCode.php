<?php

namespace App\Utilities\Errors;

class ErrorCode
{

    const SUBSCRIBER_NOT_FOUND = [
        'code' => 'Error.SubscriberNotFound',
        'message' => 'Subscriber not found'
    ];

    const SUBSCRIBER_ALREADY_EXISTS = [
        'code' => 'Error.SubscriberAlreadyExists',
        'message' => 'Subscriber already exists'
    ];


    const MISSING_VALUE = [
        'code' => 'ERR_MISSING_VALUE',
        'message' => 'The %s is required and was not provided.'
    ];

    const NOT_STRING = [
        'code' => 'ERR_NOT_STRING',
        'message' => 'The %s must be a string'
    ];

    const INVALID_EMAIL = [
        'code' => 'Error.InvalidEmail',
        'message' => 'Invalid email'
    ];

    const LENGTH_EXCEEDED = [
        'code' => 'ERR_LENGTH_EXCEEDED',
        'message' => 'The %s exceeds the maximum allowed length'
    ];
}
