<?php

declare(strict_types=1);

namespace Beeriously\Domain\Brewers\Preference\MassVolume;

interface MassVolumeMeasurementPreference
{
    public function getCode(): string;

    public function getTranslationDescriptionIdentifier(): string;
}
