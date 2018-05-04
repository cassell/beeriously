<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Application\Preference\MassVolume;

class MetricSystemPreference implements MassVolumeMeasurementPreference
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
