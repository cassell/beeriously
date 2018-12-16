<?php

declare(strict_types=1);

namespace Beeriously\Brewery;

use Beeriously\Brewer\Brewer;
use Beeriously\Brewer\BrewerInterface;
use Beeriously\Brewery\Event\BrewerNameChanged;
use Beeriously\Brewery\Event\BrewerWasAddedToBrewery;
use Beeriously\Brewery\Event\BrewerWasRemovedFromBrewery;
use Beeriously\Brewery\Event\BreweryAccountCreated;
use Beeriously\Brewery\Event\BreweryEvent;
use Beeriously\Brewery\Event\BreweryEvents;
use Beeriously\Brewery\Event\BreweryLogoChanged;
use Beeriously\Brewery\Event\BreweryMeasurementSettingsChanged;
use Beeriously\Brewery\Event\BreweryNameWasChanged;
use Beeriously\Brewery\Event\BrewerySharingSettingsChanged;
use Beeriously\Brewery\Exception\BreweryNameDidNotChangeException;
use Beeriously\Brewery\Infrastructure\Service\BreweryNameFactory;
use Beeriously\Brewery\Preference\Density\DensityPreference;
use Beeriously\Brewery\Preference\Temperature\TemperaturePreference;
use Beeriously\Brewery\Settings\BreweryMeasurementSettings;
use Beeriously\Brewery\Settings\BrewerySharingSettings;
use Beeriously\Infrastructure\File\StorageKey;
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
    public const DEFAULT_LOGO_PHOTO_KEY = 'defaults/brewery/default-brewery-logo.png';

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
     * @ORM\OneToMany(targetEntity="Beeriously\Brewer\Brewer", mappedBy="brewery", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     * @ORM\OrderBy({"lastName"="asc","firstName"="asc","username"="asc"})
     */
    private $brewers;

    /**
     * @ORM\ManyToMany(targetEntity="Beeriously\Brewery\Event\BreweryEvent", cascade={"ALL"}, fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="brewery_event_link",
     *      joinColumns={@ORM\JoinColumn(name="brewery_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="event_id", referencedColumnName="id", unique=true)}
     *      )
     * @ORM\OrderBy({"occurredOn" = "DESC"})
     */
    private $history;

    /**
     * @var BrewerySharingSettings
     *
     * @ORM\Column(type="beeriously_brewery_sharing_settings", name="sharing_settings")
     */
    private $sharingSettings;

    /**
     * @var BreweryMeasurementSettings
     *
     * @ORM\Column(type="beeriously_brewery_measurement_settings", name="measurement_settings")
     */
    private $measurementSettings;

    /**
     * @var StorageKey
     *
     * @ORM\Column(type="beeriously_storage_key", name="logo_photo_key", nullable=false)
     */
    private $logoPhotoKey;

    public function __construct(BreweryId $id,
                                BreweryName $name,
                                Brewer $accountOwner,
                                BreweryMeasurementSettings $measurementSettings,
                                BrewerySharingSettings $sharingSettings,
                                StorageKey $logo
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->brewers = new ArrayCollection();
        $this->brewers->add($accountOwner);
        $this->history = new ArrayCollection();
        $this->sharingSettings = $sharingSettings;
        $this->measurementSettings = $measurementSettings;
        $this->logoPhotoKey = $logo;
    }

    public static function fromBrewer(Brewer $brewer,
                                      BreweryNameFactory $breweryNameFactory,
                                      BreweryMeasurementSettings $measurementSettings,
                                      BrewerySharingSettings $sharingSettings,
                                      OccurredOn $occurredOn
    ): self {
        $breweryName = $breweryNameFactory->fromBrewerName($brewer->getFullName());

        $brewery = new self(
            BreweryId::newId(),
            $breweryName,
            $brewer,
            $measurementSettings,
            $sharingSettings,
            new StorageKey(self::DEFAULT_LOGO_PHOTO_KEY)
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
        return new Brewers($this->brewers->toArray());
    }

    public function addAssistantBrewer(Brewer $newBrewer, BrewerInterface $addedBy, OccurredOn $occurredOn): void
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

    public function removeAssistantBrewer(Brewer $brewer, BrewerInterface $removedBy, OccurredOn $occurredOn): void
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

    public function changeName(BreweryName $newName, BrewerInterface $changedBy, OccurredOn $occurredOn)
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

    public function recordBrewerNameChanged(BrewerInterface $brewer, BrewerInterface $changedBy, OccurredOn $occurredOn)
    {
        $this->recordThat(BrewerNameChanged::newEvent(
            $this,
            $brewer->getBrewerId(),
            $brewer->getFullName(),
            $changedBy,
            $occurredOn
        ));
    }

    public function setLogoPhotoKey(StorageKey $key, BrewerInterface $changedBy, OccurredOn $occurredOn)
    {
        $this->logoPhotoKey = $key;
        $this->recordThat(BreweryLogoChanged::newEvent(
            $this,
            $key,
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

    public function isSharingTapList(): bool
    {
        return $this->sharingSettings->isSharingTapList();
    }

    public function updateSharingSettings(BrewerySharingSettings $settings, BrewerInterface $changedBy, OccurredOn $occurredOn)
    {
        $this->sharingSettings = $settings;
        $this->recordThat(BrewerySharingSettingsChanged::newEvent(
            $this,
            $settings,
            $changedBy,
            $occurredOn
        ));
    }

    public function updateMeasurementSettings(BreweryMeasurementSettings $settings, BrewerInterface $changedBy, OccurredOn $occurredOn)
    {
        $this->measurementSettings = $settings;
        $this->recordThat(BreweryMeasurementSettingsChanged::newEvent(
            $this,
            $settings,
            $changedBy,
            $occurredOn
        ));
    }

    public function getDensityPreferenceUnits(): DensityPreference
    {
        return $this->measurementSettings->getDensity();
    }

    public function getTemperaturePreferenceUnits(): TemperaturePreference
    {
        return $this->measurementSettings->getTemperature();
    }

    /**
     * @return StorageKey
     */
    public function getLogoPhotoKey(): StorageKey
    {
        return $this->logoPhotoKey;
    }
}
