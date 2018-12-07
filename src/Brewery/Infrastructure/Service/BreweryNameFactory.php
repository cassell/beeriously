<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Service;

use Beeriously\Brewer\FullName;
use Beeriously\Brewery\BreweryName;
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
        return new BreweryName($this->translator->trans('beeriously.organization.new_brewery_name_from_brewer', ['%full_name%' => (string) $fullName]));
    }
}
