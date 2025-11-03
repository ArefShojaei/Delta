<?php

namespace Delta\Components\Http\Interfaces;


interface Http
{
    public function listen(): void;

    public static function getHeaders(): array;
}
