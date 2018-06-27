<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Domain;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Brewer\Domain\BrewerInterface;
use Beeriously\Brewer\Domain\Brewers;
use Beeriously\Brewery\Application\Name\BreweryNameFactory;
use Beeriously\Brewery\Application\Preference\Density\DensityPreference;
use Beeriously\Brewery\Application\Preference\MassVolume\MassVolumePreference;
use Beeriously\Brewery\Application\Preference\Temperature\TemperaturePreference;
use Beeriously\Brewery\Domain\Event\BrewerWasAddedToBrewery;
use Beeriously\Brewery\Domain\Event\BrewerWasRemovedFromBrewery;
use Beeriously\Brewery\Domain\Event\BreweryAccountCreated;
use Beeriously\Brewery\Domain\Event\BreweryEvent;
use Beeriously\Brewery\Domain\Event\BreweryEvents;
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
     * @var string
     *
     * @ORM\Column(type="beeriously_brewery_temperature_units_preference", name="temperature_units")
     */
    private $temperaturePreferenceUnits;

    /**
     * @ORM\OneToOne(targetEntity="Beeriously\Brewer\Application\Brewer", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="primary_brewer_id", referencedColumnName="id")
     * })
     */
    private $accountOwner;

    /**
     * @ORM\OneToMany(targetEntity="Beeriously\Brewer\Application\Brewer", mappedBy="brewery", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $brewers;

    /**
     * @ORM\OneToMany(targetEntity="Beeriously\Brewery\Domain\Event\BreweryEvent", mappedBy="brewery", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
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
        $this->accountOwner = $accountOwner;
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
        return new Brewers($this->brewers->toArray());
    }

    public function addBrewer(Brewer $newBrewer, OccurredOn $occurredOn): void
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
                $occurredOn
            )
        );
    }

    public function removeBrewer(Brewer $brewer, OccurredOn $occurredOn): void
    {
        if (!$this->brewers->contains($brewer)) {
            throw new \RuntimeException('beeriously.brewery.brewer.brewer_not_part_of_brewery_exception_message');
        }

        $this->brewers->removeElement($brewer);

        $this->recordThat(
            BrewerWasRemovedFromBrewery::newEvent(
                $this,
                $brewer,
                $occurredOn
            )
        );
    }

    public function getAccountOwner(): BrewerInterface
    {
        return $this->accountOwner;
    }

    public function getHistory(): BreweryEvents
    {
        return new BreweryEvents($this->history->toArray());
    }

    protected function apply(object $event): void
    {
        if (!$event instanceof BreweryEvent) {
            throw new \RuntimeException();
        }

        $this->history->add($event);
    }
}
