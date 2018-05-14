<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Application\Preference\Temperature;

class CelsiusPreference implements TemperatureMeasurementPreference
{
    public function getCode(): string
    {
        return 'c';
    }

    public function getTranslationDescriptionIdentifier(): string
    {
        return 'beeriously.measurements.temperature.systems.'.$this->getCode().'.description';
    }
}
