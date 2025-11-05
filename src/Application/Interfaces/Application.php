<?php

namespace Delta\Application\Interfaces;


interface Application
{
    public function boot(): void;

    public function run(): void;
}
