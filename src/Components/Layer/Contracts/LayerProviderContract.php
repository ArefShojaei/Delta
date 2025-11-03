<?php

namespace Delta\Components\Layer\Contracts;


interface LayerProviderContract
{
    public function process(): void;
}