<?php

declare(strict_types=1);

namespace Beeriously\Domain\Brewers\Preference\Density;

use Beeriously\Domain\Generic\ImmutableArray\ImmutableArray;
use InvalidArgumentException;

class DensityPreferences extends ImmutableArray
{
    public function __construct(SpecificGravityPreference $sg, PlatoPreference $plato)
    {
        parent::__construct([$sg, $plato]);
    }

    public static function validate(string $string): void
    {
        (new self(new SpecificGravityPreference(), new PlatoPreference()))->fromCode($string);
    }

    public function fromCode(string $code): DensityMeasurementPreference
    {
        foreach ($this as $pref) {
            if ($pref->getCode() === $code) {
                return $pref;
            }
        }
        throw new \InvalidArgumentException('beeriously.user.preferences.invalid_density');
    }

    protected function guardType($item)
    {
        if (!($item instanceof DensityMeasurementPreference)) {
            throw new InvalidArgumentException();
        }
    }
}
