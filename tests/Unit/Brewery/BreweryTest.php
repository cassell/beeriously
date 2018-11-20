<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery;

use Beeriously\Brewer\Brewer;
use Beeriously\Brewery\Brewery;
use Beeriously\Brewery\BreweryId;
use Beeriously\Brewery\BreweryName;
use Beeriously\Brewery\Infrastructure\Service\BreweryNameFactory;
use Beeriously\Brewery\Preference\Density\PlatoPreference;
use Beeriously\Brewery\Preference\MassVolume\MetricSystemPreference;
use Beeriously\Brewery\Preference\Temperature\CelsiusPreference;
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
            new MetricSystemPreference(),
            new PlatoPreference(),
            new CelsiusPreference(),
            OccurredOn::now(),
            $this->getMockBreweryNameFactory()
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
