<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Application\Preference\Density;

interface DensityMeasurementPreference
{
    public function getCode(): string;

    public function getTranslationDescriptionIdentifier(): string;
}
