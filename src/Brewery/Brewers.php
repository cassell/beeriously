<?php

declare(strict_types=1);

namespace Beeriously\Brewery;

use Beeriously\Brewer\BrewerInterface;
use Beeriously\Universal\ImmutableArray\ImmutableArray;
use InvalidArgumentException;

class Brewers extends ImmutableArray
{
    public function __construct(array $brewers)
    {
        if (0 === \count($brewers)) {
            throw new \RuntimeException();
        }
        parent::__construct($brewers);
    }

    /**
     * @codeCoverageIgnore
     */
    protected function guardType($item)
    {
        if (!($item instanceof BrewerInterface)) {
            throw new InvalidArgumentException();
        }
    }
}
