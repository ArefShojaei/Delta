<?php

namespace Delta\Components\Layer\Contracts;


interface LayerContract
{
    public function get(): LayerProviderContract;
}