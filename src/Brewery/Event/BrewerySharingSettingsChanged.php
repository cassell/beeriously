<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Event;

use Beeriously\Brewer\BrewerInterface;
use Beeriously\Brewery\Brewery;
use Beeriously\Brewery\Settings\BrewerySharingSettings;
use Beeriously\Universal\Time\OccurredOn;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class BrewerySharingSettingsChanged extends BreweryEvent
{
    public static function newEvent(
        Brewery $brewery,
        BrewerySharingSettings $settings,
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
                'settings' => $settings->toArray(),
            ]
        );
    }
}
