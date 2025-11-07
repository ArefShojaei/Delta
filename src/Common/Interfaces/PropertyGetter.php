<?php

namespace Delta\Common\Interfaces;


interface PropertyGetter
{
    public function __get(string $prop): mixed;
}
