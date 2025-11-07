<?php

namespace Delta\Components\Event;

use Closure;
use Delta\Common\Interfaces\PropertyGetter as IPropertyGetter;


final class Event implements IPropertyGetter
{
    public function __construct(
        private string $name,
        private Closure $callback,
    ) {}

    public function __get(string $prop): mixed
    {
        return $this->{$prop};
    }
}
