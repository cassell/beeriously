<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Preference;

interface Preference
{
    public function getCode(): string;

    public function getTranslationDescriptionIdentifier(): string;
}
