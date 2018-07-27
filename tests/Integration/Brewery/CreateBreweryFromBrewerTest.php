<?php

declare(strict_types=1);

namespace Beeriously\Tests\Integration\Brewery;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Brewery\Application\Name\BreweryNameFactory;
use Beeriously\Brewery\Application\Preference\Density\PlatoPreference;
use Beeriously\Brewery\Application\Preference\MassVolume\MetricSystemPreference;
use Beeriously\Brewery\Application\Preference\Temperature\CelsiusPreference;
use Beeriously\Brewery\Domain\Brewery;
use Beeriously\Tests\Helpers\ContainerAwareTestCase;
use Beeriously\Universal\Time\OccurredOn;
use Symfony\Component\Translation\Translator;

class CreateBreweryFromBrewerTest extends ContainerAwareTestCase
{
    public function testFromBrewerEnglish()
    {
        $translator = new Translator('us');
        $translator->addLoader('yml', new \Symfony\Component\Translation\Loader\YamlFileLoader());
        $translator->addResource('yml', __DIR__.'/../../../translations/messages.us.yml', 'us');

        $brewer = new Brewer();
        $brewer->setFirstName('Søren');
        $brewer->setLastName('Sørensen');

        $brewery = Brewery::fromBrewer(
            $brewer,
            new MetricSystemPreference(),
            new PlatoPreference(),
            new CelsiusPreference(),
            OccurredOn::now(),
            new BreweryNameFactory($translator)
        );
        $this->assertSame('Søren Sørensen\'s Brewery', $brewery->getName()->getValue());
    }

    public function testFromBrewerGerman()
    {
        $translator = new Translator('de');
        $translator->addLoader('yml', new \Symfony\Component\Translation\Loader\YamlFileLoader());
        $translator->addResource('yml', __DIR__.'/../../../translations/messages.de.yml', 'de');

        $brewer = new Brewer();
        $brewer->setFirstName('Søren');
        $brewer->setLastName('Sørensen');
        $brewery = Brewery::fromBrewer(
            $brewer,
            new MetricSystemPreference(),
            new PlatoPreference(),
            new CelsiusPreference(),
            OccurredOn::now(),
            new BreweryNameFactory($translator)
        );
        $this->assertSame('Hausbrauerei zum Søren Sørensen', $brewery->getName()->getValue());
    }
}
