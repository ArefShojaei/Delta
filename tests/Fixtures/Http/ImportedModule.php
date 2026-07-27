<?php

namespace Tests\Fixtures\Http;

use Delta\Components\Layer\Attributes\Module;

#[Module(
    controllers: [],
    providers: [],
    imports: [],
    exports: [ImportedExport::class],
)]
final class ImportedModule
{
}
