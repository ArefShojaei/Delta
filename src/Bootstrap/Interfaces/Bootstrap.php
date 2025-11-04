<?php

namespace Delta\Bootstrap\Interfaces;

use Delta\Components\Container\Container;


interface Bootstrap
{
    public function init(): void;

    public function getContainer(): ?Container;
}
