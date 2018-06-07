<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Domain;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Brewery\Application\Preference\Density\DensityPreference;
use Beeriously\Brewery\Application\Preference\MassVolume\MassVolumePreference;
use Beeriously\Brewery\Application\Preference\Temperature\TemperaturePreference;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @ORM\Table(name="brewery")
 * @ORM\Entity
 */
class Brewery
{
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
     * @var string
     *
     * @ORM\Column(type="string", name="mass_volume_units", length=2)
     */
    private $massVolumePreferenceUnits;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="density_units", length=5)
     */
    private $densityPreferenceUnits;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="temperature_units", length=1)
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

    private function __construct(BreweryId $id,
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
        $this->massVolumePreferenceUnits = $massVolumeMeasurementPreference->getCode();
        $this->densityPreferenceUnits = $densityMeasurementPreference->getCode();
        $this->temperaturePreferenceUnits = $temperatureMeasurementPreference->getCode();
    }

    public static function fromBrewer(Brewer $brewer,
                                      MassVolumePreference $massVolumeMeasurementPreference,
                                      DensityPreference $densityMeasurementPreference,
                                      TemperaturePreference $temperatureMeasurementPreference,
                                      TranslatorInterface $translator): self
    {
        $breweryName = new BreweryName($translator->trans('beeriously.organization.new_organization_name_from_brewer', ['%full_name%' => (string) $brewer->getFullName()]));

        $brewery = new self(
            BreweryId::newId(),
            $breweryName,
            $brewer,
            $massVolumeMeasurementPreference,
            $densityMeasurementPreference,
            $temperatureMeasurementPreference
        );

        $brewer->associateWithBrewery($brewery);

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
}
