<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Domain\Event;

use Beeriously\Universal\ImmutableArray\ImmutableArray;

class BreweryEvents extends ImmutableArray
{
    public function __construct(array $events)
    {
        parent::__construct($events);
    }

    /**
     * @codeCoverageIgnore
     */
    protected function guardType($item)
    {
        if (!($item instanceof BreweryEvent)) {
            throw new \InvalidArgumentException();
        }
    }
}
