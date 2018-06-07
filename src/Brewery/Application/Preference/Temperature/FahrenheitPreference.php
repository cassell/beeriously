<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Application\Preference\Temperature;

class FahrenheitPreference implements TemperaturePreference
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
