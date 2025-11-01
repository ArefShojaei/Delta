<?php

namespace Delta\Application\Contracts;


interface LayerProviderContract
{
    public function process(): void;
}