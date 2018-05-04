<?php

declare(strict_types=1);

namespace Beeriously\Tests\Integration\Brewery;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Brewery\Domain\Brewery;
use Beeriously\Tests\Helpers\ContainerAwareTestCase;
use Symfony\Component\Translation\Translator;

class CreateBreweryFromBrewerTest extends ContainerAwareTestCase
{
    public function testFromBrewerEnglish()
    {
        $translator = new Translator('en');
        $translator->addLoader('yml', new \Symfony\Component\Translation\Loader\YamlFileLoader());
        $translator->addResource('yml', __DIR__.'/../../../translations/messages.en.yml', 'en');

        $brewer = new Brewer();
        $brewer->setFirstName('Søren');
        $brewer->setLastName('Sørensen');
        $organization = Brewery::fromBrewer($brewer, $translator);
        $this->assertSame('Søren Sørensen\'s Brewery', $organization->getName()->getValue());
    }

    public function testFromBrewerGerman()
    {
        $translator = new Translator('de');
        $translator->addLoader('yml', new \Symfony\Component\Translation\Loader\YamlFileLoader());
        $translator->addResource('yml', __DIR__.'/../../../translations/messages.de.yml', 'de');

        $brewer = new Brewer();
        $brewer->setFirstName('Søren');
        $brewer->setLastName('Sørensen');
        $organization = Brewery::fromBrewer($brewer, $translator);
        $this->assertSame('Hausbrauerei zum Søren Sørensen', $organization->getName()->getValue());
    }
}
