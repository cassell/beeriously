<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Brewery\Application\Preference\Density\PlatoPreference;
use Beeriously\Brewery\Application\Preference\MassVolume\MetricSystemPreference;
use Beeriously\Brewery\Application\Preference\Temperature\CelsiusPreference;
use Beeriously\Brewery\Domain\Brewery;
use Beeriously\Brewery\Domain\BreweryId;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Translation\TranslatorInterface;

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
            $this->getMockTranslator()
        );

        $this->assertInstanceOf(BreweryId::class, $brewery->getId());
        $this->assertSame('Søren Sørensen\'s Brewery', $brewery->getName()->getValue());
        $this->assertSame('Søren Sørensen\'s Brewery', $brewer->getBrewery()->getName()->getValue());
    }

    private function getMockTranslator()
    {
        $mock = $this->getMockBuilder(TranslatorInterface::class)->getMock();
        $mock->method('trans')->willReturn('Søren Sørensen\'s Brewery');

        /* @var TranslatorInterface $mock */
        return $mock;
    }
}
