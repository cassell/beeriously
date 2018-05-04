<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Domain;

interface BrewerInterface
{
    public function getFullName(): FullName;
}
