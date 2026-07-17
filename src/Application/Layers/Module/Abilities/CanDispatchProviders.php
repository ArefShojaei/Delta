<?php

namespace Delta\Application\Layers\Module\Abilities;

use Delta\Components\Layer\LayerFactory;

trait CanDispatchProviders
{
    protected function dispatch(array $providers)
    {
        if (empty($providers)) return;

        foreach ($providers as $provider) {
            $providerLayer = LayerFactory::createProviderLayer(
                $provider,
                $this->container,
            );

            $providerLayer->process();
        }
    }
}
