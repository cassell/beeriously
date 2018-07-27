<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Domain\Event;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Brewer\Domain\BrewerInterface;
use Beeriously\Brewer\Domain\FullName;
use Beeriously\Brewery\Domain\Brewery;
use Beeriously\Universal\Time\OccurredOn;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class BrewerWasRemovedFromBrewery extends BreweryEvent
{
    public static function newEvent(
        Brewery $brewery,
        Brewer $brewer,
        BrewerInterface $removedBy,
        OccurredOn $occurredOn
    ): self {
        return new self(
            BreweryEventId::newId(),
            $brewery->getId(),
            $removedBy->getBrewerId(),
            $removedBy->getFullName(),
            $occurredOn,
            [
                'brewer' => [
                    'id' => $brewer->getBrewerId()->getValue(),
                    'name' => $brewer->getFullName()->serialize(),
                ],
            ]
        );
    }

    public function getBrewerRemovedFullName(): FullName
    {
        return FullName::deserialize($this->getData()['brewer']['name']);
    }
}
