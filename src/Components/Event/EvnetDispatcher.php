<?php

namespace Delta\Components\Event;

use Closure;
use Delta\Components\Event\Contracts\EventDispatcherContract;
use Exception;


final class EvnetDispatcher implements EventDispatcherContract {
    private array $listeners = [];


    public function addListener(string $event, Closure $listener): void {
        if ($this->has($event)) throw new Exception("{$event} event already exists!");
        
        $this->listeners[$event] = $listener;
    }   
    
    public function dispatch(string $event, mixed $data = []): void {
        $listener = $this->listeners[$event];

        call_user_func($listener, $data);
    }

    private function has(string $event): bool {
        return isset($this->listeners[$event]);
    }
}