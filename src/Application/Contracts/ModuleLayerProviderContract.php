<?php

namespace Delta\Application\Contracts;


interface ModuleLayerProviderContract
{
    public function process(): void;
}
