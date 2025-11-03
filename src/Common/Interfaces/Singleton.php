<?php

namespace Delta\Common\Interfaces;


interface Singleton
{
    public static function getInstance(): self;
}
