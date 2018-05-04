<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Domain;

use Beeriously\Brewer\Application\Brewer;
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
     * @ORM\OneToMany(targetEntity="Beeriously\Brewer\Application\Brewer", mappedBy="organization")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $brewers;

    private function __construct(BreweryName $name,
                                 Brewer $brewer)
    {
        $this->id = BreweryId::newId()->getValue();
        $this->name = $name->getValue();
        $this->brewers = new ArrayCollection();
        $this->brewers->add($brewer);
        $brewer->associateWithOrganization($this);
    }

    public static function fromBrewer(Brewer $brewer,
                                      TranslatorInterface $translator)
    {
        $breweryName = new BreweryName($translator->trans('beeriously.organization.new_organization_name_from_brewer', ['%full_name%' => (string) $brewer->getFullName()]));

        return new self($breweryName, $brewer);
    }

    public function getName(): BreweryName
    {
        return new BreweryName($this->name);
    }
}
