<?php

namespace Delta\Common;

use Delta\Common\Interfaces\{Arrayable, PropertySetter};


abstract class Entity implements PropertySetter, Arrayable
{
    public function __set(string $prop, mixed $value): void
    {
        if (property_exists($this, $prop)) {
            $this->{$prop} = $value;
        }
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
