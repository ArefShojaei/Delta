<?php

namespace Delta\Application\Enums;


enum LayerTypeEnum: string
{
    case MODULE = "module";
    case CONTROLLER = "controller";
    case SERVICE = "service";
}