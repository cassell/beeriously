<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Application\Preference\MassVolume;

interface MassVolumeMeasurementPreference
{
    public function getCode(): string;

    public function getTranslationDescriptionIdentifier(): string;
}