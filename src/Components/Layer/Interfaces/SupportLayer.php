<?php

namespace Delta\Components\Layer\Interfaces;

interface SupportLayer
{
    public function setParentModule(string|object $module): void;

    public function getParentModule(): string|object|null;
}
