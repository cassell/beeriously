<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Application\Brewer;

use Beeriously\Application\Brewers\Brewer;
use PHPUnit\Framework\TestCase;

class DefaultBrewerUnits extends TestCase
{
    public function testThatDefaultBrewerHasFahrenheitUnits()
    {
        $brewer = new Brewer();
        $this->assertSame('f', $brewer->getTemperaturePreferenceUnits());
    }

    public function testThatDefaultBrewerHasUSCustomaryUnits()
    {
        $brewer = new Brewer();
        $this->assertSame('us', $brewer->getMassVolumePreferenceUnits());
    }

    public function testThatDefaultBrewerHasSpecificGravity()
    {
        $brewer = new Brewer();
        $this->assertSame('sg', $brewer->getDensityPreferenceUnits());
    }
}
