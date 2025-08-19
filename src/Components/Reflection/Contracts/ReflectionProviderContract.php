<?php

namespace Delta\Components\Reflection\Contracts;


interface ReflectionProviderContract
{
    public function __get(string $name);
}
