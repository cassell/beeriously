<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Domain\Event;

use Beeriously\Brewer\Domain\BrewerId;
use Beeriously\Brewer\Domain\FullName;
use Beeriously\Universal\Event\Event;
use Beeriously\Universal\Time\OccurredOn;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\DiscriminatorColumn(name="event", type="string")
 * @ORM\Table(name="brewery_event")
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
                                   BrewerId $createdById,
                                   FullName $createdByFullName,
                                   OccurredOn $occurredOn,
                                   array $eventData
    ) {
        $this->id = $id;
        $this->createdById = $createdById;
        $this->createdByFullName = $createdByFullName;
        $this->occurredOn = $occurredOn;
        $this->data = $eventData;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getCreatedByFullName(): FullName
    {
        return $this->createdByFullName;
    }

    public function getOccurredOn(): OccurredOn
    {
        return $this->occurredOn;
    }
}
