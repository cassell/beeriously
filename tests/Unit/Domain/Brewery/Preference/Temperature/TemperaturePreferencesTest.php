<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Brewery\Preference\Temperature;

use Beeriously\Brewery\Application\Preference\Temperature\FahrenheitPreference;
use Beeriously\Brewery\Application\Preference\Temperature\TemperaturePreferences;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class TemperaturePreferencesTest extends TestCase
{
    public function testConstructor()
    {
        $prefs = TemperaturePreferences::create();
        $this->assertInstanceOf(FahrenheitPreference::class, $prefs[0]);
        $this->assertInstanceOf(\Beeriously\Brewery\Application\Preference\Temperature\CelsiusPreference::class, $prefs[1]);
        $this->assertSame(2, count($prefs));
    }
}
