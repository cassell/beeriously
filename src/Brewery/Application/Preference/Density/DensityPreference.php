<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Application\Preference\Density;

interface DensityPreference
{
    public function getCode(): string;

    public function getTranslationDescriptionIdentifier(): string;
}