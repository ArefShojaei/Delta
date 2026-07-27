<?php

namespace Tests\Fixtures\Http;

use Delta\Components\Layer\Attributes\Module;

#[Module(
    controllers: [DemoController::class],
    providers: [DemoProvider::class],
    imports: [ImportedModule::class],
    exports: [DemoExport::class],
)]
final class DemoModule
{
}
