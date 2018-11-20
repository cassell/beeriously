<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Preference\MassVolume;

interface MassVolumePreference
{
    public function getCode(): string;

    public function getTranslationDescriptionIdentifier(): string;
}
