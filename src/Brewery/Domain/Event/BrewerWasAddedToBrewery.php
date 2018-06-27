<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Domain\Event;

use Beeriously\Brewer\Domain\BrewerInterface;
use Beeriously\Brewery\Domain\Brewery;
use Beeriously\Universal\Time\OccurredOn;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class BrewerWasAddedToBrewery extends BreweryEvent
{
    public static function newEvent(
                                Brewery $brewery,
                                BrewerInterface $newBrewer,
                                OccurredOn $occurredOn): self
    {
        return new self(
            BreweryEventId::newId(),
            $brewery->getId(),
            $brewery->getAccountOwner()->getBrewerId(),
            $brewery->getAccountOwner()->getFullName(),
            $occurredOn,
            [
            'brewer' => [
                'id' => $newBrewer->getBrewerId()->getValue(),
                'name' => $newBrewer->getFullName()->serialize(),
            ],
        ]);
    }
}
