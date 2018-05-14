<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Application\Preference\Temperature;

interface TemperatureMeasurementPreference
{
    public function getCode(): string;

    public function getTranslationDescriptionIdentifier(): string;
}
