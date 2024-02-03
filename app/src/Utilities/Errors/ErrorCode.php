<?php

namespace App\Utilities\Errors;

class ErrorCode
{
    const INVALID_SUBSCRIBER_ID = [
        'code' => 'Error.InvalidSubscriberId',
        'message' => 'Invalid subscriber ID'
    ];

    const INVALID_STATUS_ID = [
        'code' => 'Error.InvalidStatusId',
        'message' => 'Invalid status ID'
    ];

    const SUBSCRIBER_NOT_FOUND = [
        'code' => 'Error.SubscriberNotFound',
        'message' => 'Subscriber not found'
    ];

    const STATUS_NOT_FOUND = [
        'code' => 'Error.StatusNotFound',
        'message' => 'Status not found'
    ];

    const MISSING_VALUE = [
        'code' => 'ERR_MISSING_VALUE',
        'message' => 'The %s is required and was not provided.'
    ];

    const NOT_INTEGER = [
        'code' => 'ERR_NOT_INTEGER',
        'message' => 'The %s must be integer.'
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
