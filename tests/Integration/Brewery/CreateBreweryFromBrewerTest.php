<?php

declare(strict_types=1);

namespace Beeriously\Tests\Integration\Brewery;

use Beeriously\Brewer\Brewer;
use Beeriously\Brewer\Infrastructure\Registration\Form\MassVolume\MetricSystemPreference;
use Beeriously\Brewer\Infrastructure\Registration\Form\MassVolume\UnitedStatesCustomarySystemPreference;
use Beeriously\Brewery\Brewery;
use Beeriously\Brewery\Infrastructure\Service\BreweryNameFactory;
use Beeriously\Brewery\Preference\Density\PlatoPreference;
use Beeriously\Brewery\Preference\Temperature\CelsiusPreference;
use Beeriously\Brewery\Preference\Temperature\FahrenheitPreference;
use Beeriously\Brewery\Settings\BreweryMeasurementSettings;
use Beeriously\Brewery\Settings\BrewerySharingSettings;
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
            new BreweryNameFactory($translator),
            BreweryMeasurementSettings::setup(
                new FahrenheitPreference(),
                new PlatoPreference(),
                new UnitedStatesCustomarySystemPreference()
            ),
            BrewerySharingSettings::defaultNotSharing(),
            OccurredOn::now()
        );
        $this->assertEquals('Søren Sørensen\'s Brewery', $brewery->getName()->getValue());
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
            new BreweryNameFactory($translator),
            BreweryMeasurementSettings::setup(
                new CelsiusPreference(),
                new PlatoPreference(),
                new MetricSystemPreference()
            ),
            BrewerySharingSettings::defaultNotSharing(),
            OccurredOn::now()
        );
        $this->assertEquals('Hausbrauerei zum Søren Sørensen', $brewery->getName()->getValue());
    }
}
