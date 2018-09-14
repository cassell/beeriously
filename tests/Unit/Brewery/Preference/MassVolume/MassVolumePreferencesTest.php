<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery\Preference\MassVolume;

use Beeriously\Brewery\Application\Preference\MassVolume\MassVolumePreferences;
use Beeriously\Brewery\Application\Preference\MassVolume\MetricSystemPreference;
use Beeriously\Brewery\Application\Preference\MassVolume\UnitedStatesCustomarySystemPreference;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class MassVolumePreferencesTest extends TestCase
{
    public function testConstructor()
    {
        $prefs = MassVolumePreferences::create();
        $this->assertInstanceOf(UnitedStatesCustomarySystemPreference::class, $prefs[0]);
        $this->assertInstanceOf(MetricSystemPreference::class, $prefs[1]);
        $this->assertEquals(2, \count($prefs));
    }
}
