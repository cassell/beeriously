<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Domain\Event;

use Beeriously\Brewer\BrewerId;
use Beeriously\Brewer\BrewerInterface;
use Beeriously\Brewer\FullName;
use Beeriously\Brewery\Domain\Brewery;
use Beeriously\Universal\Time\OccurredOn;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class BrewerNameChanged extends BreweryEvent
{
    public static function newEvent(
        Brewery $brewery,
        BrewerId $brewerId,
        FullName $brewerName,
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
                'brewer' => [
                    'id' => $brewerId,
                    'name' => $brewerName->serialize(),
                ],
            ]
        );
    }

    public function getBrewerNewFullName(): FullName
    {
        return FullName::deserialize($this->getData()['brewer']['name']);
    }
}
