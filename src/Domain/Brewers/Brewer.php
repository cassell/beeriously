<?php

declare(strict_types=1);

namespace Beeriously\Domain\Brewers;
use Beeriously\Application\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="brewer")
 * @ORM\Entity
 */
class Brewer extends User
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=50, nullable=false)
     * @ORM\Id
     */
    protected $id;

    public function __construct()
    {
        $this->id = BrewerId::newId()->getValue();
        parent::__construct();
    }

}
