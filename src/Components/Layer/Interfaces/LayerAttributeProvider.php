<?php

namespace Delta\Components\Layer\Interfaces;

use Delta\Common\Interfaces\Processor;

interface LayerAttributeProvider extends Processor
{
    public function getAttributeControllers(): array;

    public function getAttributeProviders(): array;

    public function getAttributeImports(): array;

    public function getAttributeExports(): array;
}
