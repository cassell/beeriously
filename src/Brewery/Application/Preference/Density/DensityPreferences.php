<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Application\Preference\Density;

use Beeriously\Domain\Generic\ImmutableArray\ImmutableArray;
use InvalidArgumentException;

class DensityPreferences extends ImmutableArray
{
    public function __construct(SpecificGravityPreference $sg, PlatoPreference $plato)
    {
        parent::__construct([$sg, $plato]);
    }

    public static function create()
    {
        return new self(
            new SpecificGravityPreference(),
            new PlatoPreference()
        );
    }

    protected function guardType($item)
    {
        if (!($item instanceof DensityPreference)) {
            throw new InvalidArgumentException();
        }
    }
}
