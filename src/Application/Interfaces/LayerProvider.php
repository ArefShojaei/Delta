<?php

namespace Delta\Application\Interfaces;


interface LayerProvider
{
    public function process(): void;
}