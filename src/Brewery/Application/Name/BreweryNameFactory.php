<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Application\Name;

use Beeriously\Brewer\Domain\FullName;
use Beeriously\Brewery\Domain\BreweryName;
use Symfony\Component\Translation\TranslatorInterface;

class BreweryNameFactory
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function fromBrewerName(FullName $fullName): BreweryName
    {
        return new BreweryName($this->translator->trans('beeriously.organization.new_organization_name_from_brewer', ['%full_name%' => (string) $fullName]));
    }
}
