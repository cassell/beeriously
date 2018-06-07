<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Domain;

use Beeriously\Domain\Generic\ValueObject\Identifier;

final class BreweryId extends Identifier
{
    public function __toString(): string
    {
        return $this->getValue();
    }
}
