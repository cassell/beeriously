<?php

declare(strict_types=1);

namespace Beeriously\Domain\Brewers\Preference\Density;

class PlatoPreference implements DensityMeasurementPreference
{
    public function getCode(): string
    {
        return 'plato';
    }

    public function getTranslationDescriptionIdentifier(): string
    {
        return 'beeriously.measurements.density.systems.'.$this->getCode().'.description';
    }
}
