<?php

namespace Delta\Application\Providers;

use Delta\Application\Contracts\LayerProviderContract;
use Delta\Application\Mixins\Layers\Module\{
    HasModuleControllersDispatcherMixin,
    HasModuleExportsDispatcherMixin,
    HasModuleImportsDispatcherMixin,
    HasModuleProvidersDispatcherMixin
};


final class ModuleLayerProvider implements LayerProviderContract
{
    use HasModuleControllersDispatcherMixin, HasModuleProvidersDispatcherMixin, 
        HasModuleImportsDispatcherMixin, HasModuleExportsDispatcherMixin 
        {
            HasModuleControllersDispatcherMixin::dispatch insteadof
            HasModuleProvidersDispatcherMixin,
            HasModuleImportsDispatcherMixin,
            HasModuleExportsDispatcherMixin;

            HasModuleControllersDispatcherMixin::dispatch as private dispatchControllers;
            HasModuleProvidersDispatcherMixin::dispatch as private dispatchProviders;
            HasModuleImportsDispatcherMixin::dispatch as private dispatchImports;
            HasModuleExportsDispatcherMixin::dispatch as private dispatchExports;
        }


    public function __construct(private readonly string $module)
    {
    }

    public function process(): void {
        $this->dispatchControllers();
        
        $this->dispatchProviders();
        
        $this->dispatchImports();
        
        $this->dispatchExports();
    }
}
