<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Domain\Event;

use Beeriously\Brewery\Domain\Brewery;
use Beeriously\Universal\Time\OccurredOn;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class BreweryAccountCreated extends BreweryEvent
{
    public static function newEvent(Brewery $brewery, OccurredOn $occurredOn): self
    {
        return new self(
            BreweryEventId::newId(),
            $brewery->getId(),
            $brewery->getAccountOwner()->getBrewerId(),
            $brewery->getAccountOwner()->getFullName(),
            $occurredOn,
            []  // no additional data
        );
    }
}
