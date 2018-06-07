<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Application\Preference\Density;

class PlatoPreference implements DensityPreference
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
