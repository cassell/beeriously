<?php

declare(strict_types=1);

namespace Beeriously\Domain\Brewers\Preference\Density;

interface DensityMeasurementPreference
{
    public function getCode(): string;

    public function getTranslationDescriptionIdentifier(): string;
}
