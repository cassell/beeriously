<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Application\Preference\Density;

class SpecificGravityPreference implements DensityPreference
{
    public function getCode(): string
    {
        return 'sg';
    }

    public function getTranslationDescriptionIdentifier(): string
    {
        return 'beeriously.measurements.density.systems.'.$this->getCode().'.description';
    }
}