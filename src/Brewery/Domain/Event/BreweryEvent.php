<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Domain\Event;

use Beeriously\Brewer\Domain\BrewerId;
use Beeriously\Brewer\Domain\FullName;
use Beeriously\Brewery\Domain\BreweryId;
use Beeriously\Universal\Event\Event;
use Beeriously\Universal\Time\OccurredOn;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\DiscriminatorColumn(name="event", type="string")
 * @ORM\Table(name="brewery_events")
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
abstract class BreweryEvent extends Event
{
    /**
     * @var BreweryEventId
     *
     * @ORM\Column(type="beeriously_brewery_event_id")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var BreweryId
     *
     * @ORM\Column(type="beeriously_brewery_id")
     */
    private $breweryId;

    /**
     * @var OccurredOn
     *
     * @ORM\Column(type="json_array")
     */
    private $data;

    /**
     * @var OccurredOn
     *
     * @ORM\Column(type="beeriously_occurred_on")
     */
    private $occurredOn;

    /**
     * @var BrewerId
     * @ORM\Column(type="beeriously_brewer_id")
     */
    private $createdById;

    /**
     * @var FullName
     * @ORM\Column(type="beeriously_brewer_full_name")
     */
    private $createdByFullName;

    protected function __construct(BreweryEventId $id,
                                   BreweryId $breweryId,
                                   BrewerId $createdById,
                                   FullName $createdByFullName,
                                   OccurredOn $occurredOn,
                                   array $eventData
    ) {
        $this->id = $id;
        $this->breweryId = $breweryId;
        $this->createdById = $createdById;
        $this->createdByFullName = $createdByFullName;
        $this->occurredOn = $occurredOn;
        $this->data = $eventData;
    }
}
