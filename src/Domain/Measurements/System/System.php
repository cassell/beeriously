<?php

declare(strict_types=1);

namespace Beeriously\Domain\Measurements\System;

interface System
{
    public function getId(): string;

    public function getTranslationDescriptionIdentifier(): string;
}
