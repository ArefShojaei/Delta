<?php

namespace Delta\Components\Event\Interfaces;

use Closure;


interface EventDispatcher
{
    public function addListener(string $event, Closure $listener): void;

    public function dispatch(string $event, mixed $data = []): void;
}
