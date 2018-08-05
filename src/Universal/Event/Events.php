<?php

declare(strict_types=1);

namespace Beeriously\Universal\Event;

use Beeriously\Universal\ImmutableArray\ArrayIsImmutable;
use Beeriously\Universal\ImmutableArray\ImmutableArray;

class Events extends ImmutableArray
{
    protected function guardType($item): void
    {
        if (!($item instanceof Event)) {
            throw new ArrayIsImmutable();
        }
    }
}
