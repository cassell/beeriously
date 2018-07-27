<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Domain\Event;

use Beeriously\Brewer\Domain\BrewerInterface;
use Beeriously\Brewer\Domain\FullName;
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
                                BrewerInterface $createdBy,
                                OccurredOn $occurredOn): self
    {
        return new self(
            BreweryEventId::newId(),
            $brewery->getId(),
            $createdBy->getBrewerId(),
            $createdBy->getFullName(),
            $occurredOn,
            [
            'brewer' => [
                'id' => $newBrewer->getBrewerId()->getValue(),
                'name' => $newBrewer->getFullName()->serialize(),
            ],
        ]);
    }

    public function getBrewerAddedFullName()
    {
        return FullName::deserialize($this->getData()['brewer']['name']);
    }
}
