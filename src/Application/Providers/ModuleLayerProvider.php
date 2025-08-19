<?php

namespace Delta\Application\Providers;

use Delta\Application\Attributes\Module;
use Delta\Application\Contracts\ModuleLayerProviderContract;
use Delta\Application\Mixins\HasModulePropertyProcessor as HasPropertyProcessor;
use Delta\Components\Reflection\Providers\ClassReflectionProvider;
use Delta\Components\Routing\Router;


final class ModuleLayerProvider implements ModuleLayerProviderContract
{
    use HasPropertyProcessor;

    private ClassReflectionProvider $module;

    private Router $router;


    public function __construct(string $module, array $meta)
    {
        $this->module = new ClassReflectionProvider($module, Module::class);

        $this->router = $meta["router"];
    }


    public function process(): void {
        $meta = $this->module->descriptor->meta;

        $this->applyControllers(controllers: $meta["controllers"]);
    }
}
