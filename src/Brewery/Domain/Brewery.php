<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Domain;

use Beeriously\Brewer\Application\Preference\Density\DensityMeasurementPreference;
use Beeriously\Brewer\Application\Preference\MassVolume\MassVolumeMeasurementPreference;
use Beeriously\Brewer\Application\Preference\Temperature\TemperatureMeasurementPreference;
use Beeriously\Brewer\Domain\BrewerInterface;
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
     * @var string
     *
     * @ORM\Column(type="string", length=36)
     * @ORM\Id()
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=250)
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
     * @ORM\OneToMany(targetEntity="Beeriously\Brewer\Application\Brewer", mappedBy="brewery")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $brewers;

    private function __construct(BreweryName $name,
                                 MassVolumeMeasurementPreference $massVolumeMeasurementPreference,
                                 DensityMeasurementPreference $densityMeasurementPreference,
                                 TemperatureMeasurementPreference $temperatureMeasurementPreference)
    {
        $this->id = BreweryId::newId()->getValue();
        $this->brewers = new ArrayCollection();
        $this->name = $name->getValue();
        $this->massVolumePreferenceUnits = $massVolumeMeasurementPreference->getCode();
        $this->densityPreferenceUnits = $densityMeasurementPreference->getCode();
        $this->temperaturePreferenceUnits = $temperatureMeasurementPreference->getCode();
    }

    public static function fromBrewer(BrewerInterface $brewer,
                                      MassVolumeMeasurementPreference $massVolumeMeasurementPreference,
                                      DensityMeasurementPreference $densityMeasurementPreference,
                                      TemperatureMeasurementPreference $temperatureMeasurementPreference,
                                      TranslatorInterface $translator): self
    {
        $breweryName = new BreweryName($translator->trans('beeriously.organization.new_organization_name_from_brewer', ['%full_name%' => (string) $brewer->getFullName()]));

        $brewery = new self($breweryName,
            $massVolumeMeasurementPreference,
            $densityMeasurementPreference,
            $temperatureMeasurementPreference
        );

        $brewery->brewers->add($brewer);
        $brewer->associateWithBrewery($brewery);

        return $brewery;
    }

    public function getName(): BreweryName
    {
        return new BreweryName($this->name);
    }
}
