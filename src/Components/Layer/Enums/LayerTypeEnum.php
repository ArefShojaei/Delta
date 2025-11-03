<?php

namespace Delta\Components\Layer\Enums;


enum LayerTypeEnum: string
{
    case MODULE = "module";
    case CONTROLLER = "controller";
    case SERVICE = "service";
}