<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Domain;

use Beeriously\Brewer\Brewer;
use Beeriously\Brewer\BrewerInterface;
use Beeriously\Brewery\Brewers;
use Beeriously\Brewery\Application\Name\BreweryNameFactory;
use Beeriously\Brewery\Application\Preference\Density\DensityPreference;
use Beeriously\Brewery\Application\Preference\MassVolume\MassVolumePreference;
use Beeriously\Brewery\Application\Preference\Temperature\TemperaturePreference;
use Beeriously\Brewery\Domain\Event\BrewerNameChanged;
use Beeriously\Brewery\Domain\Event\BrewerWasAddedToBrewery;
use Beeriously\Brewery\Domain\Event\BrewerWasRemovedFromBrewery;
use Beeriously\Brewery\Domain\Event\BreweryAccountCreated;
use Beeriously\Brewery\Domain\Event\BreweryEvent;
use Beeriously\Brewery\Domain\Event\BreweryEvents;
use Beeriously\Brewery\Domain\Event\BreweryNameWasChanged;
use Beeriously\Brewery\Domain\Exception\BreweryNameDidNotChangeException;
use Beeriously\Universal\Time\OccurredOn;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use EventSauce\EventSourcing\AggregateRootBehaviour\EventRecordingBehaviour;

/**
 * @ORM\Table(name="brewery")
 * @ORM\Entity
 */
class Brewery
{
    use EventRecordingBehaviour;

    /**
     * @var BreweryId
     *
     * @ORM\Column(type="beeriously_brewery_id")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var BreweryName
     *
     * @ORM\Column(type="beeriously_brewery_name")
     */
    private $name;

    /**
     * @var MassVolumePreference
     *
     * @ORM\Column(type="beeriously_brewery_mass_volume_units_preference", name="mass_volume_units")
     */
    private $massVolumePreferenceUnits;

    /**
     * @var DensityPreference
     *
     * @ORM\Column(type="beeriously_brewery_density_units_preference", name="density_units")
     */
    private $densityPreferenceUnits;

    /**
     * @var TemperaturePreference
     *
     * @ORM\Column(type="beeriously_brewery_temperature_units_preference", name="temperature_units")
     */
    private $temperaturePreferenceUnits;

    /**
     * @ORM\OneToMany(targetEntity="Beeriously\Brewer\Brewer", mappedBy="brewery", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     * @ORM\OrderBy({"lastName"="asc","firstName"="asc","username"="asc"})
     */
    private $brewers;

    /**
     * @ORM\ManyToMany(targetEntity="Beeriously\Brewery\Domain\Event\BreweryEvent", cascade={"ALL"}, fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="brewery_event_link",
     *      joinColumns={@ORM\JoinColumn(name="brewery_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="event_id", referencedColumnName="id", unique=true)}
     *      )
     * @ORM\OrderBy({"occurredOn" = "DESC"})
     */
    private $history;

    public function __construct(BreweryId $id,
                                BreweryName $name,
                                Brewer $accountOwner,
                                MassVolumePreference $massVolumeMeasurementPreference,
                                DensityPreference $densityMeasurementPreference,
                                TemperaturePreference $temperatureMeasurementPreference)
    {
        $this->id = $id;
        $this->name = $name;
        $this->brewers = new ArrayCollection();
        $this->brewers->add($accountOwner);
        $this->massVolumePreferenceUnits = $massVolumeMeasurementPreference;
        $this->densityPreferenceUnits = $densityMeasurementPreference;
        $this->temperaturePreferenceUnits = $temperatureMeasurementPreference;
        $this->history = new ArrayCollection();
    }

    public static function fromBrewer(Brewer $brewer,
                                      MassVolumePreference $massVolumeMeasurementPreference,
                                      DensityPreference $densityMeasurementPreference,
                                      TemperaturePreference $temperatureMeasurementPreference,
                                      OccurredOn $occurredOn,
                                      BreweryNameFactory $breweryNameFactory
    ): self {
        $breweryName = $breweryNameFactory->fromBrewerName($brewer->getFullName());

        $brewery = new self(
            BreweryId::newId(),
            $breweryName,
            $brewer,
            $massVolumeMeasurementPreference,
            $densityMeasurementPreference,
            $temperatureMeasurementPreference
        );

        $brewer->associateWithBrewery($brewery);

        $brewery->recordThat(
            BreweryAccountCreated::newEvent(
                $brewery,
                $brewer,
                $occurredOn
            )
        );

        return $brewery;
    }

    public function getName(): BreweryName
    {
        return $this->name;
    }

    /**
     * @return BreweryId
     */
    public function getId(): BreweryId
    {
        return $this->id;
    }

    public function getBrewers(): Brewers
    {
        return new \Beeriously\Brewery\Brewers($this->brewers->toArray());
    }

    public function addAssistantBrewer(Brewer $newBrewer, \Beeriously\Brewer\BrewerInterface $addedBy, OccurredOn $occurredOn): void
    {
        if ($this->brewers->contains($newBrewer)) {
            throw new \RuntimeException('beeriously.brewery.brewer.brewer_already_part_of_brewery_exception_message');
        }

        $newBrewer->associateWithBrewery($this);
        $this->brewers->add($newBrewer);

        $this->recordThat(
            BrewerWasAddedToBrewery::newEvent(
                $this,
                $newBrewer,
                $addedBy,
                $occurredOn
            )
        );
    }

    public function removeAssistantBrewer(Brewer $brewer, \Beeriously\Brewer\BrewerInterface $removedBy, OccurredOn $occurredOn): void
    {
        if (!$this->brewers->contains($brewer)) {
            throw new \RuntimeException('beeriously.brewery.brewer.brewer_not_part_of_brewery_exception_message');
        }

        $this->brewers->removeElement($brewer);

        $this->recordThat(
            BrewerWasRemovedFromBrewery::newEvent(
                $this,
                $brewer,
                $removedBy,
                $occurredOn
            )
        );
    }

    public function getHistory(): BreweryEvents
    {
        return new BreweryEvents($this->history->toArray());
    }

    public function changeName(BreweryName $newName, \Beeriously\Brewer\BrewerInterface $changedBy, OccurredOn $occurredOn)
    {
        $oldName = $this->name;

        if ($oldName->equals($newName)) {
            throw new BreweryNameDidNotChangeException();
        }

        $this->name = $newName;

        $this->recordThat(
            BreweryNameWasChanged::newEvent(
                $this,
                $oldName,
                $newName,
                $changedBy,
                $occurredOn
            )
        );
    }

    public function recordBrewerNameChanged(BrewerInterface $brewer, \Beeriously\Brewer\BrewerInterface $changedBy, OccurredOn $occurredOn)
    {
        $this->recordThat(BrewerNameChanged::newEvent(
            $this,
            $brewer->getBrewerId(),
            $brewer->getFullName(),
            $changedBy,
            $occurredOn
        ));
    }

    /**
     * @codeCoverageIgnore
     */
    protected function apply(object $event): void
    {
        if (!$event instanceof BreweryEvent) {
            throw new \RuntimeException();
        }

        $this->history->add($event);
    }

    public function getMassVolumePreferenceUnits(): MassVolumePreference
    {
        return $this->massVolumePreferenceUnits;
    }

    public function getDensityPreferenceUnits(): DensityPreference
    {
        return $this->densityPreferenceUnits;
    }

    public function getTemperaturePreferenceUnits(): TemperaturePreference
    {
        return $this->temperaturePreferenceUnits;
    }
}
