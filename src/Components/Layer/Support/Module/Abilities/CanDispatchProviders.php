<?php

namespace Delta\Components\Layer\Support\Module\Abilities;

use Delta\Components\Layer\Factory\LayerFactory;

trait CanDispatchProviders
{
    protected function dispatch(array $providers)
    {
        if (empty($providers)) return;

        foreach ($providers as $provider) {
            $layer = LayerFactory::createProviderLayer(
                $provider,
                $this->container,
            );

            $layer->process();
        }
    }
}
