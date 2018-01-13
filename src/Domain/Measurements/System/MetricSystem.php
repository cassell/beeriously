<?php

declare(strict_types=1);

namespace Beeriously\Domain\Measurements\System;

class MetricSystem implements System
{
    public function getId(): string
    {
        return 'si';
    }

    public function getTranslationDescriptionIdentifier(): string
    {
        return 'beeriously.measurements.system.si.description';
    }
}
