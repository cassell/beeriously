<?php

declare(strict_types=1);

namespace Beeriously\Domain\Measurements\System;

class Systems
{
    public static function fromId(string $unitId)
    {
        if ('us' === $unitId) {
            return new UnitedStatesCustomarySystem();
        } elseif ('si' === $unitId) {
            return new MetricSystem();
        }
        throw new \InvalidArgumentException();
    }

    public static function toId(System $system)
    {
        switch (get_class($system)) {
            case MetricSystem::class:
                return 'si';
                break;
            case UnitedStatesCustomarySystem::class:
            default:
                return'us';
        }
    }
}
