<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery\Preference\Temperature;

use Beeriously\Brewery\Preference\Temperature\FahrenheitPreference;
use Beeriously\Brewery\Preference\Temperature\TemperaturePreferences;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class TemperaturePreferencesTest extends TestCase
{
    public function testConstructor()
    {
        $prefs = TemperaturePreferences::create();
        $this->assertInstanceOf(FahrenheitPreference::class, $prefs[0]);
        $this->assertInstanceOf(\Beeriously\Brewery\Preference\Temperature\CelsiusPreference::class, $prefs[1]);
        $this->assertEquals(2, \count($prefs));
    }
}
