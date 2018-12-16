<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Infrastructure\Registration\Form\MassVolume;

class MetricSystemPreference implements MassVolumePreference
{
    public function getCode(): string
    {
        return 'si';
    }

    public function getTranslationDescriptionIdentifier(): string
    {
        return 'beeriously.measurements.mass_volume.systems.'.$this->getCode().'.description';
    }
}
