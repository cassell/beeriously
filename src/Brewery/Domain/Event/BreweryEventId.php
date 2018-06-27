<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Domain\Event;

use Beeriously\Universal\Identification\Identifier;

class BreweryEventId extends Identifier
{
    public function __toString(): string
    {
        return $this->getValue();
    }
}
