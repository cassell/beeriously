<?php

declare(strict_types=1);

namespace Beeriously\Application\Brewers;

use Beeriously\Application\User\User;
use Beeriously\Domain\Brewers\BrewerId;
use Beeriously\Domain\Brewers\BrewerInterface;
use Beeriously\Domain\Brewers\FirstName;
use Beeriously\Domain\Brewers\FullName;
use Beeriously\Domain\Brewers\LastName;
use Beeriously\Domain\Brewers\Preference\Density\DensityMeasurementPreference;
use Beeriously\Domain\Brewers\Preference\Density\DensityPreferences;
use Beeriously\Domain\Brewers\Preference\Density\PlatoPreference;
use Beeriously\Domain\Brewers\Preference\Density\SpecificGravityPreference;
use Beeriously\Domain\Brewers\Preference\MassVolume\MassVolumeMeasurementPreference;
use Beeriously\Domain\Brewers\Preference\MassVolume\MassVolumePreferences;
use Beeriously\Domain\Brewers\Preference\MassVolume\MetricSystemPreference;
use Beeriously\Domain\Brewers\Preference\MassVolume\UnitedStatesCustomarySystemPreference;
use Beeriously\Domain\Brewers\Preference\Temperature\CelsiusPreference;
use Beeriously\Domain\Brewers\Preference\Temperature\FahrenheitPreference;
use Beeriously\Domain\Brewers\Preference\Temperature\TemperatureMeasurementPreference;
use Beeriously\Domain\Brewers\Preference\Temperature\TemperaturePreferences;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\EquatableInterface;

/**
 * @ORM\Table(name="brewer")
 * @ORM\Entity
 */
class Brewer extends User implements BrewerInterface, EquatableInterface
{
    public const ROLE_VALID_BREWER = 'ROLE_VALID_BREWER';

    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=50, nullable=false)
     * @ORM\Id
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="first_name", length=50)
     */
    private $firstName = "";

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="last_name", length=50)
     */
    private $lastName = "";

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

    public function __construct()
    {
        parent::__construct();
        $this->id = BrewerId::newId()->getValue();
        $this->massVolumePreferenceUnits = (new UnitedStatesCustomarySystemPreference())->getCode();
        $this->densityPreferenceUnits = (new SpecificGravityPreference())->getCode();
        $this->temperaturePreferenceUnits = (new FahrenheitPreference())->getCode();
    }

//    public function completeRegistrationBecauseFriendsOfSymfonyUserBundleDoesNotLikeAdditionalConstructorParameters(FullName $fullName,
//                                                                                                                    MassVolumeMeasurementPreference $massVolumeMeasurementPreference,
//                                                                                                                    DensityMeasurementPreference $densityMeasurementPreference,
//                                                                                                                    TemperatureMeasurementPreference $temperaturePreference)
//    {
//        if ($this->hasRole(self::ROLE_VALID_BREWER)) {
//            throw new \RuntimeException('Already validated');
//        }
//
//        $this->firstName = $fullName->getFirstName()->getValue();
//        $this->lastName = $fullName->getLastName()->getValue();
//        $this->massVolumePreferenceUnits = $massVolumeMeasurementPreference->getCode();
//        $this->densityPreferenceUnits = $densityMeasurementPreference->getCode();
//        $this->temperaturePreferenceUnits = $temperaturePreference->getCode();
//
//        $this->addRole(self::ROLE_VALID_BREWER);
//    }

    public function getBrewerId(): BrewerId
    {
        return BrewerId::fromString($this->id);
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = (string) new FirstName($firstName);
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = (string) new LastName($lastName);
    }

    /**
     * @return string
     */
    public function getMassVolumePreferenceUnits(): string
    {
        return $this->massVolumePreferenceUnits;
    }

    /**
     * @param string $massVolumePreferenceUnits
     */
    public function setMassVolumePreferenceUnits(string $massVolumePreferenceUnits): void
    {
        $this->massVolumePreferenceUnits = $massVolumePreferenceUnits;
    }

    /**
     * @return string
     */
    public function getDensityPreferenceUnits(): string
    {
        return $this->densityPreferenceUnits;
    }

    /**
     * @param string $densityPreferenceUnits
     */
    public function setDensityPreferenceUnits(string $densityPreferenceUnits): void
    {
        $this->densityPreferenceUnits = $densityPreferenceUnits;
    }

    /**
     * @return string
     */
    public function getTemperaturePreferenceUnits(): string
    {
        return $this->temperaturePreferenceUnits;
    }

    /**
     * @param string $temperaturePreferenceUnits
     */
    public function setTemperaturePreferenceUnits(string $temperaturePreferenceUnits): void
    {
        $this->temperaturePreferenceUnits = $temperaturePreferenceUnits;
    }

    public function isEqualTo(\Symfony\Component\Security\Core\User\UserInterface $user)
    {
        // https://stackoverflow.com/questions/13798662/when-are-user-roles-refreshed-and-how-to-force-it#13837102
        if ($user instanceof self) {
            // Check that the roles are the same, in any order
            $isEqual = count($this->getRoles()) === count($user->getRoles());
            if ($isEqual) {
                foreach ($this->getRoles() as $role) {
                    $isEqual = $isEqual && in_array($role, $user->getRoles(), true);
                }
            }

            return $isEqual;
        }

        return false;
    }

    public function getFullName(): FullName
    {
        return new FullName(new FirstName($this->firstName), new LastName($this->lastName));
    }


//    public function getMassVolumePreference(): MassVolumeMeasurementPreference
//    {
//        return (new MassVolumePreferences(
//            new UnitedStatesCustomarySystemPreference(),
//            new MetricSystemPreference()
//        ))->fromCode($this->massVolumePreferenceUnits);
//    }
//
//    public function getDensityPreference(): DensityMeasurementPreference
//    {
//        return (new DensityPreferences(
//            new SpecificGravityPreference(),
//            new PlatoPreference()
//        ))->fromCode($this->densityPreferenceUnits);
//    }
//
//    public function getTemperaturePreference(): TemperatureMeasurementPreference
//    {
//        return (new TemperaturePreferences(
//            new FahrenheitPreference(),
//            new CelsiusPreference()
//        ))->fromCode($this->temperaturePreferenceUnits);
//    }
}
