<?php

namespace App\Utilities\Exceptions;

use Exception;

class DatabaseException extends \Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        error_log($message);
    }
}
