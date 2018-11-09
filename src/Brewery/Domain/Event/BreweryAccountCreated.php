<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Domain\Event;

use Beeriously\Brewer\BrewerInterface;
use Beeriously\Brewery\Domain\Brewery;
use Beeriously\Universal\Time\OccurredOn;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class BreweryAccountCreated extends BreweryEvent
{
    public static function newEvent(Brewery $brewery, BrewerInterface $createdBy, OccurredOn $occurredOn): self
    {
        return new self(
            BreweryEventId::newId(),
            $brewery->getId(),
            $createdBy->getBrewerId(),
            $createdBy->getFullName(),
            $occurredOn,
            []  // no additional data
        );
    }
}
