<?php

namespace Delta\Components\Routing\Exceptions;

use Exception;

use Delta\Components\Http\HttpStatus;

final class RouteNotFound extends Exception
{
    public function __construct()
    {
        $statusCode = HttpStatus::HTTP_NOT_FOUND;

        $message = "Route not found";

        parent::__construct($message, $statusCode);
    }
}
