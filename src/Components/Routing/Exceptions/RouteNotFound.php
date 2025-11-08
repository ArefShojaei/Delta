<?php

namespace Delta\Components\Routing\Exceptions;

use Delta\Components\Http\HttpStatus;
use Exception;


final class RouteNotFound extends Exception {
    public function __construct()
    {
        $statusCode = HttpStatus::HTTP_NOT_FOUND;

        $message = "Route not found";

        parent::__construct($message, $statusCode);
    }
}