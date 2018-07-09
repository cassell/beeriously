<?php
declare(strict_types=1);

namespace Beeriously\Brewery\Domain\Event;

use Beeriously\Brewery\Domain\Brewery;
use Beeriously\Brewery\Domain\BreweryName;
use Beeriously\Universal\Time\OccurredOn;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class BreweryNameWasChanged extends BreweryEvent
{
    public static function newEvent(Brewery $brewery, BreweryName $newName, OccurredOn $occurredOn): self
    {
        return new self(
            BreweryEventId::newId(),
            $brewery->getAccountOwner()->getBrewerId(),
            $brewery->getAccountOwner()->getFullName(),
            $occurredOn,
            [
                'brewery' => [
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