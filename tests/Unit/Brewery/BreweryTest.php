<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Brewery\Application\Name\BreweryNameFactory;
use Beeriously\Brewery\Application\Preference\Density\PlatoPreference;
use Beeriously\Brewery\Application\Preference\MassVolume\MetricSystemPreference;
use Beeriously\Brewery\Application\Preference\Temperature\CelsiusPreference;
use Beeriously\Brewery\Domain\Brewery;
use Beeriously\Brewery\Domain\BreweryId;
use Beeriously\Brewery\Domain\BreweryName;
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
        $this->assertSame('Søren Sørensen\'s Brewery', $brewery->getName()->getValue());
        $this->assertSame('Søren Sørensen\'s Brewery', $brewer->getBrewery()->getName()->getValue());
    }

    private function getMockBreweryNameFactory()
    {
        $mock = $this->getMockBuilder(BreweryNameFactory::class)->disableOriginalConstructor()->getMock();
        $mock->method('fromBrewerName')->willReturn(new BreweryName('Søren Sørensen\'s Brewery'));

        /* @var BreweryNameFactory $mock */
        return $mock;
    }
}
