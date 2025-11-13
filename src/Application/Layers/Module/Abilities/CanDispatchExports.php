<?php

namespace Delta\Application\Layers\Module\Abilities;

use Delta\Components\Layer\LayerFactory;


trait CanDispatchExports
{
    protected function dispatch(array $exports) {
        foreach ($exports as $provider) {
            $subProviderLayer = LayerFactory::createProviderLayer($provider, $this->container);

            $subProviderLayer->process();
        }
    }
}
