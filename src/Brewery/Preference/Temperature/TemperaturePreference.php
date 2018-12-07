<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Preference\Temperature;

interface TemperaturePreference
{
    public function getCode(): string;

    public function getTranslationDescriptionIdentifier(): string;
}
