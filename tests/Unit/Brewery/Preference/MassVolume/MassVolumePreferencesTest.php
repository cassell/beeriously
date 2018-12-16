<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery\Preference\MassVolume;

use Beeriously\Brewer\Infrastructure\Registration\Form\MassVolume\MassVolumePreferences;
use Beeriously\Brewer\Infrastructure\Registration\Form\MassVolume\MetricSystemPreference;
use Beeriously\Brewer\Infrastructure\Registration\Form\MassVolume\UnitedStatesCustomarySystemPreference;
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
