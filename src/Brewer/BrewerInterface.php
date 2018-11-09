<?php

declare(strict_types=1);

namespace Beeriously\Brewer;

use Beeriously\Brewer\BrewerId;
use Beeriously\Brewer\FullName;
use Beeriously\Brewery\Domain\Brewery;
use Beeriously\Infrastructure\File\StorageKey;

interface BrewerInterface
{
    public function getFullName(): FullName;

    public function getBrewery(): Brewery;

    public function getBrewerId(): BrewerId;

    public function setProfilePhotoKey(StorageKey $key);
}