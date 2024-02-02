<?php

namespace App\Utilities\Errors;

class ErrorCode
{
    const INVALID_SUBSCRIBER_ID = [
        'code' => 'Error.InvalidSubscriberId',
        'message' => 'Invalid subscriber ID'
    ];

    const SUBSCRIBER_NOT_FOUND = [
        'code' => 'Error.SubscriberNotFound',
        'message' => 'Subscriber not found'
    ];

    const MISSING_VALUE = [
        'code' => 'ERR_MISSING_VALUE',
        'message' => 'The %s is required and was not provided.'
    ];

    const NOT_NUMERIC = [
        'code' => 'ERR_NOT_NUMERIC',
        'message' => 'The %s must be numeric.'
    ];

    const NOT_STRING = [
        'code' => 'ERR_NOT_STRING',
        'message' => 'The %s must be a string.'
    ];

    const INVALID_STATUS = [
        'code' => 'ERR_INVALID_STATUS',
        'message' => 'The %s value is not valid.'
    ];

    const LENGTH_EXCEEDED = [
        'code' => 'ERR_LENGTH_EXCEEDED',
        'message' => 'The %s exceeds the maximum allowed length.'
    ];
}
