<?php

namespace Delta\Common\Interfaces;


interface PropertySetter
{
    public function __set(string $prop, mixed $value): void;
}
