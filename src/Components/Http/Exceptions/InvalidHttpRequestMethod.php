<?php

namespace Delta\Components\Http\Exceptions;

use Delta\Common\Interfaces\PropertyGetter as IPropertyGetter;
use Delta\Components\Http\HttpStatus;
use Exception;


final class InvalidHttpRequestMethod extends Exception implements IPropertyGetter
{
    public function __construct(private string $method)
    {
        $statusCode = HttpStatus::HTTP_METHOD_NOT_ALLOWED;

        $message = "HTTP method not allowed";

        parent::__construct($message, $statusCode);
    }

    public function __get(string $prop): mixed
    {
        return $this->{$prop};
    }
}
