<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Application\Preference\MassVolume;

interface MassVolumePreference
{
    public function getCode(): string;

    public function getTranslationDescriptionIdentifier(): string;
}
