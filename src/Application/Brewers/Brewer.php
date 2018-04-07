<?php

declare(strict_types=1);

namespace Beeriously\Application\Brewers;

use Beeriously\Application\User\User;
use Beeriously\Domain\Brewers\BrewerId;
use Beeriously\Domain\Brewers\BrewerInterface;
use Beeriously\Domain\Brewers\FirstName;
use Beeriously\Domain\Brewers\FullName;
use Beeriously\Domain\Brewers\LastName;
use Beeriously\Domain\Brewers\Preference\Density\DensityPreferences;
use Beeriously\Domain\Brewers\Preference\Density\SpecificGravityPreference;
use Beeriously\Domain\Brewers\Preference\MassVolume\MassVolumePreferences;
use Beeriously\Domain\Brewers\Preference\MassVolume\UnitedStatesCustomarySystemPreference;
use Beeriously\Domain\Brewers\Preference\Temperature\FahrenheitPreference;
use Beeriously\Domain\Brewers\Preference\Temperature\TemperaturePreferences;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\EquatableInterface;

/**
 * @ORM\Table(name="brewer")
 * @ORM\Entity(repositoryClass="\Beeriously\Application\Repository\DoctrineBrewerRepository")
 */
class Brewer extends User implements BrewerInterface, EquatableInterface
{
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
     * @ORM\Column(type="string", name="first_name", length=100)
     */
    private $firstName = '';

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="last_name", length=100)
     */
    private $lastName = '';

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
        MassVolumePreferences::validate($massVolumePreferenceUnits);
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
        DensityPreferences::validate($densityPreferenceUnits);
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
        TemperaturePreferences::validate($temperaturePreferenceUnits);
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
}
