<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Brewery;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Brewer\Application\Preference\Density\PlatoPreference;
use Beeriously\Brewer\Application\Preference\MassVolume\MetricSystemPreference;
use Beeriously\Brewer\Application\Preference\Temperature\CelsiusPreference;
use Beeriously\Brewery\Domain\Brewery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Translation\TranslatorInterface;

class BreweryTest extends TestCase
{
    public function testFromBrewer()
    {
        $brewer = new Brewer();
        $brewer->setFirstName('Søren');
        $brewer->setLastName('Sørensen');
        $brewery = Brewery::fromBrewer($brewer,
            new MetricSystemPreference(),
            new PlatoPreference(),
            new CelsiusPreference(),
            $this->getMockTranslator()
        );
        $this->assertSame('Søren Sørensen\'s Brewery', $brewery->getName()->getValue());
    }

    private function getMockTranslator()
    {
        $mock = $this->getMockBuilder(TranslatorInterface::class)->getMock();
        $mock->method('trans')->willReturn('Søren Sørensen\'s Brewery');

        /* @var TranslatorInterface $mock */
        return $mock;
    }
}
