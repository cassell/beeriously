<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Preference\Temperature;

class CelsiusPreference implements TemperaturePreference
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
