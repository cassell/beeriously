<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery\Preference\Density;

use Beeriously\Brewery\Preference\Density\DensityPreferences;
use Beeriously\Brewery\Preference\Density\PlatoPreference;
use Beeriously\Brewery\Preference\Density\SpecificGravityPreference;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class DensityPreferencesTest extends TestCase
{
    public function testConstructor()
    {
        $prefs = DensityPreferences::create();
        $this->assertInstanceOf(SpecificGravityPreference::class, $prefs[0]);
        $this->assertInstanceOf(PlatoPreference::class, $prefs[1]);
        $this->assertEquals(2, \count($prefs));
    }
}
