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
        $this->assertEquals('f',$brewer->getTemperaturePreferenceUnits());
    }

    public function testThatDefaultBrewerHasUSCustomaryUnits()
    {
        $brewer = new Brewer();
        $this->assertEquals('us',$brewer->getMassVolumePreferenceUnits());
    }

    public function testThatDefaultBrewerHasSpecificGravity()
    {
        $brewer = new Brewer();
        $this->assertEquals('sg',$brewer->getDensityPreferenceUnits());
    }

}