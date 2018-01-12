<?php

declare(strict_types=1);

namespace Beeriously\Domain\Brewers;

use Beeriously\Application\User\User;
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
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="last_name", length=50)
     */
    private $lastName;

    public function __construct()
    {
        $this->id = BrewerId::newId()->getValue();
        parent::__construct();
    }

    public function completeRegistration(FullName $fullName)
    {
        if ($this->hasRole(self::ROLE_VALID_BREWER)) {
            throw new \RuntimeException('Already validated');
        }

        $this->firstName = $fullName->getFirstName()->getValue();
        $this->lastName = $fullName->getLastName()->getValue();

        $this->addRole(self::ROLE_VALID_BREWER);
    }

    public function getBrewerId(): BrewerId
    {
        return BrewerId::fromString($this->id);
    }

    public function getFullName(): FullName
    {
        return new FullName(new FirstName($this->firstName), new LastName($this->lastName));
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
}
