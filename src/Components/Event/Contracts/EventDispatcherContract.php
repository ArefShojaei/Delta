<?php

namespace Delta\Components\Event\Contracts;

use Closure;


interface EventDispatcherContract {
    public function addListener(string $event, Closure $listener): void;
    public function dispatch(string $event, mixed $data = []): void;
}