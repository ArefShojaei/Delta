<?php

namespace Delta\Components\Layer;

use Delta\Components\Layer\Interfaces\SupportLayer as ISupportLayer;

abstract class BaseSupportLayer implements ISupportLayer
{
    private string|object $parentModule;

    public function setParentModule(string|object $module): void
    {
        $this->parentModule = $module;
    }

    public function getParentModule(): string|object|null
    {
        return $this->parentModule ?? null;
    }
}
