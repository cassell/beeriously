<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery\Preference\Density;

use Beeriously\Brewery\Preference\Density\DensityPreferenceFactory;
use Beeriously\Brewery\Preference\Density\PlatoPreference;
use Beeriously\Brewery\Preference\Density\SpecificGravityPreference;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class DensityPreferenceFactoryTest extends TestCase
{
    public function testCreate()
    {
        $this->assertInstanceOf(DensityPreferenceFactory::class, DensityPreferenceFactory::create());
    }

    public function testInvalidCode()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('beeriously.user.preferences.invalid_density');
        DensityPreferenceFactory::create()->fromCode('xxx');
    }

    public function testFromCode()
    {
        $factory = DensityPreferenceFactory::create();
        $this->assertInstanceOf(SpecificGravityPreference::class, $factory->fromCode('sg'));
        $this->assertInstanceOf(PlatoPreference::class, $factory->fromCode('plato'));
    }
}
