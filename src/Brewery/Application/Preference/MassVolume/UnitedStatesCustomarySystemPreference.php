<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Application\Preference\MassVolume;

class UnitedStatesCustomarySystemPreference implements MassVolumePreference
{
    public function getCode(): string
    {
        return 'us';
    }

    public function getTranslationDescriptionIdentifier(): string
    {
        return 'beeriously.measurements.mass_volume.systems.'.$this->getCode().'.description';
    }
}