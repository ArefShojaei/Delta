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
            HasModuleControllersDispatcherMixin::dispatch as dispatchControllers;
            HasModuleProvidersDispatcherMixin::dispatch as dispatchProviders;
            HasModuleImportsDispatcherMixin::dispatch as dispatchImports;
            HasModuleExportsDispatcherMixin::dispatch as dispatchExports;
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
