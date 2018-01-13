<?php

declare(strict_types=1);

namespace Beeriously\Domain\Measurements\System;

class UnitedStatesCustomarySystem implements System
{
    public function getId(): string
    {
        return 'us';
    }

    public function getTranslationDescriptionIdentifier(): string
    {
        return 'beeriously.measurements.system.us.description';
    }
}
