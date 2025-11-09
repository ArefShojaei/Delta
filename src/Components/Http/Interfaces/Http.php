<?php

namespace Delta\Components\Http\Interfaces;


interface Http
{
    public function listen(): void;

    public function applyMiddlewares(array $middlewares): void;
}
