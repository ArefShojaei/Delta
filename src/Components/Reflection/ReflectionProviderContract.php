<?php

namespace Delta\Components\Reflection;


interface ReflectionProviderContract
{
    public function __get(string $name);
}
