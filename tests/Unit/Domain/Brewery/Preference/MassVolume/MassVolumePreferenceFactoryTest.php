<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Brewery\Preference\MassVolume;

use Beeriously\Brewery\Application\Preference\MassVolume\MassVolumePreferenceFactory;
use Beeriously\Brewery\Application\Preference\MassVolume\MetricSystemPreference;
use Beeriously\Brewery\Application\Preference\MassVolume\UnitedStatesCustomarySystemPreference;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class MassVolumePreferenceFactoryTest extends TestCase
{
    public function testCreate()
    {
        $this->assertInstanceOf(MassVolumePreferenceFactory::class, MassVolumePreferenceFactory::create());
    }

    public function testFromCode()
    {
        $factory = MassVolumePreferenceFactory::create();
        $this->assertInstanceOf(UnitedStatesCustomarySystemPreference::class, $factory->fromCode('us'));
        $this->assertInstanceOf(MetricSystemPreference::class, $factory->fromCode('si'));
    }
}
