<?php

declare(strict_types=1);

namespace Beeriously\Brewer;

use Beeriously\Brewer\BrewerId;
use Beeriously\Brewer\BrewerInterface;
use Beeriously\Brewer\FirstName;
use Beeriously\Brewer\FullName;
use Beeriously\Brewer\LastName;
use Beeriously\Brewery\Domain\Brewery;
use Beeriously\Infrastructure\File\StorageKey;
use Beeriously\Infrastructure\User\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\EquatableInterface;

/**
 * @ORM\Table(name="brewer")
 * @ORM\Entity(repositoryClass="\Beeriously\Brewer\Infrastructure\DoctrineBrewerRepository")
 * @Beeriously\Brewer\Infrastructure\Constraint\BrewerConstraint
 */
class Brewer extends User implements BrewerInterface, EquatableInterface
{
    public const DEFAULT_PROFILE_PHOTO_KEY = 'defaults/brewer/default-user-photo.png';

    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=50, nullable=false)
     * @ORM\Id
     */
    protected $id; // must be protected as \FOS\UserBundle\Model\User uses it directly

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
     * @ORM\Column(type="string", name="profile_photo_key", length=255, nullable=true)
     */
    private $profilePhotoKey;

    /**
     * @ORM\ManyToOne(targetEntity="Beeriously\Brewery\Domain\Brewery", inversedBy="brewers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="brewery_id", referencedColumnName="id")
     * })
     */
    private $brewery;

    public function __construct()
    {
        parent::__construct();

        // must be done here because of \FOS\UserBundle\Model\User
        $this->id = BrewerId::newId()->getValue();

        $this->profilePhotoKey = self::DEFAULT_PROFILE_PHOTO_KEY;
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
     * @codeCoverageIgnore
     */
    public function isEqualTo(\Symfony\Component\Security\Core\User\UserInterface $user)
    {
        // https://stackoverflow.com/questions/13798662/when-are-user-roles-refreshed-and-how-to-force-it#13837102
        if (!$user instanceof self) {
            return false;
        }
        if ($user->getId() !== $this->getId()) {
            return false;
        }

        return true;
    }

    public function associateWithBrewery(Brewery $brewery): void
    {
        $this->brewery = $brewery;
    }

    public function getFullName(): FullName
    {
        return new FullName(new FirstName($this->firstName), new LastName($this->lastName));
    }

    public function getBrewery(): Brewery
    {
        return $this->brewery;
    }

    public function disassociateWithBrewery(): void
    {
        $this->brewery = null;
    }

    public function setProfilePhotoKey(StorageKey $key): void
    {
        $this->profilePhotoKey = (string) $key;
    }

    public function getProfilePhotoKey(): StorageKey
    {
        return new StorageKey($this->profilePhotoKey);
    }
}
