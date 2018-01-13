<?php
declare(strict_types=1);

namespace Beeriously\Domain\Measurements\System;

class Systems
{
    public static function fromId(string $unitId)
    {
        if($unitId == 'us') {
            return new UnitedStatesCustomarySystem();
        } elseif($unitId == 'si') {
            return new MetricSystem();
        } else {
            throw new \InvalidArgumentException();
        }
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