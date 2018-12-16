<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Event;

use Beeriously\Brewer\BrewerInterface;
use Beeriously\Brewery\Brewery;
use Beeriously\Infrastructure\File\StorageKey;
use Beeriously\Universal\Time\OccurredOn;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class BreweryLogoChanged extends BreweryEvent
{
    public static function newEvent(Brewery $brewery, StorageKey $storageKey, BrewerInterface $createdBy, OccurredOn $occurredOn): self
    {
        return new self(
            BreweryEventId::newId(),
            $brewery->getId(),
            $createdBy->getBrewerId(),
            $createdBy->getFullName(),
            $occurredOn,
            [
                'key' => $storageKey->getValue(),
            ]);
    }
}
