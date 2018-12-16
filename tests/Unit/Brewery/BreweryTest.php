<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery;

use Beeriously\Brewer\Brewer;
use Beeriously\Brewer\Infrastructure\Registration\Form\MassVolume\MetricSystemPreference;
use Beeriously\Brewery\Brewery;
use Beeriously\Brewery\BreweryId;
use Beeriously\Brewery\BreweryName;
use Beeriously\Brewery\Infrastructure\Service\BreweryNameFactory;
use Beeriously\Brewery\Preference\Density\PlatoPreference;
use Beeriously\Brewery\Preference\Temperature\CelsiusPreference;
use Beeriously\Brewery\Settings\BreweryMeasurementSettings;
use Beeriously\Brewery\Settings\BrewerySharingSettings;
use Beeriously\Universal\Time\OccurredOn;
use PHPUnit\Framework\TestCase;

class BreweryTest extends TestCase
{
    public function testFromBrewer()
    {
        $brewer = new Brewer();
        $brewer->setFirstName('Søren');
        $brewer->setLastName('Sørensen');
        $brewery = Brewery::fromBrewer(
            $brewer,
            $this->getMockBreweryNameFactory(),
            BreweryMeasurementSettings::setup(
                new CelsiusPreference(),
                new PlatoPreference(),
                new MetricSystemPreference()
            ),
            BrewerySharingSettings::defaultNotSharing(),
            OccurredOn::now()
        );

        $this->assertInstanceOf(BreweryId::class, $brewery->getId());
        $this->assertEquals('Søren Sørensen\'s Brewery', $brewery->getName()->getValue());
        $this->assertEquals('Søren Sørensen\'s Brewery', $brewer->getBrewery()->getName()->getValue());
    }

    private function getMockBreweryNameFactory()
    {
        $mock = $this->getMockBuilder(BreweryNameFactory::class)->disableOriginalConstructor()->getMock();
        $mock->method('fromBrewerName')->willReturn(new BreweryName('Søren Sørensen\'s Brewery'));

        /* @var \Beeriously\Brewery\Infrastructure\Name\BreweryNameFactory $mock */
        return $mock;
    }
}
