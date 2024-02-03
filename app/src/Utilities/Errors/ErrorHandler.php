<?php

namespace App\Utilities\Errors;

class ErrorHandler
{
    public function __construct()
    {
        set_exception_handler([$this, 'handleException']);
        set_error_handler([$this, 'handleError']);
    }

    public function handleException($exception)
    {
        $statusCode = $exception->getCode() ?: 500;
        $errorMessage = $exception->getMessage() ?: 'Internal Server error';

        response()->json(['error' => $errorMessage], $statusCode);
    }

    public function handleError($errno, $errstr, $errfile, $errline)
    {
        $statusCode = 500;
        $errorMessage = $errstr ?: 'Internal Server error';

        response()->json(['error' => $errorMessage], $statusCode);
        exit;
    }
}
