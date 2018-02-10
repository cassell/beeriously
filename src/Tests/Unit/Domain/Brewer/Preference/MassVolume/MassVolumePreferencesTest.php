<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Brewer\Preference\MassVolume;

use Beeriously\Domain\Brewers\Preference\MassVolume\MassVolumePreferences;
use Beeriously\Domain\Brewers\Preference\MassVolume\MetricSystemPreference;
use Beeriously\Domain\Brewers\Preference\MassVolume\UnitedStatesCustomarySystemPreference;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class MassVolumePreferencesTest extends TestCase
{
    public function testConstructor()
    {
        $prefs = $this->build();
        $this->assertInstanceOf(UnitedStatesCustomarySystemPreference::class, $prefs[0]);
        $this->assertInstanceOf(MetricSystemPreference::class, $prefs[1]);
        $this->assertSame(2, count($prefs));
    }

    public function testFromCode()
    {
        $prefs = $this->build();
        $this->assertInstanceOf(UnitedStatesCustomarySystemPreference::class, $prefs->fromCode('us'));
        $this->assertInstanceOf(MetricSystemPreference::class, $prefs->fromCode('si'));
    }

    /**
     * @return MassVolumePreferences
     */
    private function build(): MassVolumePreferences
    {
        return new MassVolumePreferences(new UnitedStatesCustomarySystemPreference(), new MetricSystemPreference());
    }
}
