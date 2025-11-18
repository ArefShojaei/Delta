<?php

namespace Delta\Components\Http\Interfaces;


interface RequestValidator
{
    public function validate(): bool;

    public function getValidationErrors(): array;
}
