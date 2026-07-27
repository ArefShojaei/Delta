<?php

namespace Tests\Fixtures\Http;

use Delta\Components\Layer\Attributes\Injectable;

#[Injectable]
final class DemoProvider
{
    public function value(): string
    {
        return 'provider';
    }
}
