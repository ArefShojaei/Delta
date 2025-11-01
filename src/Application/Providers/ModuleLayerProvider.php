<?php

namespace Delta\Application\Providers;

use Delta\Application\Contracts\LayerProviderContract;
use Delta\Application\Mixins\Layers\Module\{
    HasModuleControllersDispatcherMixin,
    HasModuleExportsDispatcherMixin,
    HasModuleImportsDispatcherMixin,
    HasModuleLayerAttributeGetterMixin,
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
    
    use HasModuleLayerAttributeGetterMixin;
    

    public function __construct(private readonly string $module)
    {
    }

    public function process(): void {
        $this->dispatchControllers($this->getAttributeControllers());
        
        $this->dispatchProviders($this->getAttributeProviders());
        
        $this->dispatchImports($this->getAttributeImports());
        
        $this->dispatchExports($this->getAttributeExports());
    }
}
