<?php

namespace Delta\Components\Layer\Support\Export;

use Delta\Components\Container\Container;
use Delta\Components\Layer\BaseSupportLayer;
use Delta\Common\Interfaces\Processor as IProcessor;

final class ExportLayer extends BaseSupportLayer implements IProcessor
{
    public function __construct(
        private readonly string|object $provider,
        private Container $container,
    ) {}

    public function process(): void {}
}
