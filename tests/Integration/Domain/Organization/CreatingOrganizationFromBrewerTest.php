<?php

declare(strict_types=1);

namespace Beeriously\Tests\Integration\Domain\Organization;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Domain\Organization\Organization;
use Beeriously\Tests\Helpers\ContainerAwareTestCase;
use Symfony\Component\Translation\Translator;

class CreatingOrganizationFromBrewerTest extends ContainerAwareTestCase
{
    public function testFromBrewer()
    {
        $translator = new Translator('en');
        $translator->addLoader('yml', new \Symfony\Component\Translation\Loader\YamlFileLoader());
        $translator->addResource('yml', __DIR__.'/../../../../translations/messages.en.yml', 'en');

        $brewer = new Brewer();
        $brewer->setFirstName('Søren');
        $brewer->setLastName('Sørensen');
        $organization = Organization::fromBrewer($brewer, $translator);
        $this->assertSame('Søren Sørensen\'s Brewery', $organization->getName()->getValue());
    }
}
