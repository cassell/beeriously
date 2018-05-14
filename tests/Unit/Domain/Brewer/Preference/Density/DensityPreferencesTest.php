<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Brewer\Preference\Density;

use Beeriously\Brewer\Application\Preference\Density\DensityPreferences;
use Beeriously\Brewer\Application\Preference\Density\PlatoPreference;
use Beeriously\Brewer\Application\Preference\Density\SpecificGravityPreference;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class DensityPreferencesTest extends TestCase
{
    public function testConstructor()
    {
        $prefs = $this->build();
        $this->assertInstanceOf(SpecificGravityPreference::class, $prefs[0]);
        $this->assertInstanceOf(PlatoPreference::class, $prefs[1]);
        $this->assertSame(2, count($prefs));
    }

    public function testFromCode()
    {
        $prefs = $this->build();
        $this->assertInstanceOf(SpecificGravityPreference::class, $prefs->fromCode('sg'));
        $this->assertInstanceOf(PlatoPreference::class, $prefs->fromCode('plato'));
    }

    /**
     * @return DensityPreferences
     */
    private function build(): DensityPreferences
    {
        return new DensityPreferences(
            new SpecificGravityPreference(),
            new PlatoPreference()
        );
    }
}
