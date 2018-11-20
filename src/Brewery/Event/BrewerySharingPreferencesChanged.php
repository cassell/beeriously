<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Event;

use Beeriously\Brewer\BrewerInterface;
use Beeriously\Brewery\Brewery;
use Beeriously\Brewery\BrewerySharingPreferences;
use Beeriously\Universal\Time\OccurredOn;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class BrewerySharingPreferencesChanged extends BreweryEvent
{
    public static function newEvent(
        Brewery $brewery,
        BrewerySharingPreferences $preferences,
        BrewerInterface $createdBy,
        OccurredOn $occurredOn
    ): self {
        return new self(
            BreweryEventId::newId(),
            $brewery->getId(),
            $createdBy->getBrewerId(),
            $createdBy->getFullName(),
            $occurredOn,
            [
                'preferences' => $preferences->toArray(),
            ]
        );
    }
}
