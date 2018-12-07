<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Event;

use Beeriously\Brewer\BrewerInterface;
use Beeriously\Brewery\Brewery;
use Beeriously\Brewery\BreweryName;
use Beeriously\Universal\Time\OccurredOn;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class BreweryNameWasChanged extends BreweryEvent
{
    public static function newEvent(
        Brewery $brewery,
        BreweryName $oldName,
        BreweryName $newName,
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
                'brewery' => [
                    'oldName' => $oldName->getValue(),
                    'name' => $newName->getValue(),
                ],
            ]
        );
    }

    public function getBreweryName(): BreweryName
    {
        return new BreweryName($this->getData()['brewery']['name']);
    }
}
