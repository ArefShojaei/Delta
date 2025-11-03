<?php

namespace Delta\Common\Contracts;


interface SingletonContract {
    public static function getInstance(): self;
}