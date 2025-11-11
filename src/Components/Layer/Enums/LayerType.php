<?php

namespace Delta\Components\Layer\Enums;


enum LayerType: string
{
    case MODULE = "module";

    case CONTROLLER = "controller";

    case PROVIDER = "provider";
}
