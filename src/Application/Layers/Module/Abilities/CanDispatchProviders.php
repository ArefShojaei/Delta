<?php

namespace Delta\Application\Layers\Module\Abilities;

use Delta\Components\Layer\Attributes\Injectable;
use ReflectionClass;


trait CanDispatchProviders
{
    protected function dispatch(array $providers) {
        foreach ($providers as $provider) {
            $providerReflection = new ReflectionClass($provider);

            if (!$this->isInjected($providerReflection)) break;

            dd($providerReflection->newInstance("Hello"));
        }
    }

    private function isInjected(ReflectionClass $reflection)
    {
        $attributes = $reflection->getAttributes(Injectable::class);

        return empty($attributes) ? false : true;
    }

    private function getProvider(ReflectionClass $reflection) {
        $attributes = $reflection->getAttributes(Injectable::class);

        return current($attributes)->newInstance();
    }
}
