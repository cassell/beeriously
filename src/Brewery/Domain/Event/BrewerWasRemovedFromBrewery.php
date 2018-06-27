<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Domain\Event;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Brewery\Domain\Brewery;
use Beeriously\Universal\Time\OccurredOn;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class BrewerWasRemovedFromBrewery extends BreweryEvent
{
    public static function newEvent(Brewery $brewery, Brewer $brewer, OccurredOn $occurredOn): self
    {
        return new self(
            BreweryEventId::newId(),
            $brewery->getId(),
            $brewery->getAccountOwner()->getBrewerId(),
            $brewery->getAccountOwner()->getFullName(),
            $occurredOn,
            [
                'brewer' => [
                    'id' => $brewer->getBrewerId()->getValue(),
                    'name' => $brewer->getFullName()->serialize(),
                ],
            ]
        );
    }
}
