<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Application\Preference\Temperature;

class FahrenheitPreference implements TemperatureMeasurementPreference
{
    public function getCode(): string
    {
        return 'f';
    }

    public function getTranslationDescriptionIdentifier(): string
    {
        return 'beeriously.measurements.temperature.systems.'.$this->getCode().'.description';
    }
}
