<?php

namespace Delta\Components\Event;

use Closure;


final class Event
{
    public function __construct(
        private string $name,
        private Closure $callback,
    ) {}

    public function __get($name)
    {
        return $this->{$name};
    }
}
