<?php

namespace Delta\Components\Http\Exceptions;

use Delta\Components\Http\HttpStatus;
use Exception;


final class InternalServerError extends Exception
{
    public function __construct()
    {
        $statusCode = HttpStatus::HTTP_INTERNAL_SERVER_ERROR;

        $message = "Internal server error";

        parent::__construct($message, $statusCode);
    }
}
