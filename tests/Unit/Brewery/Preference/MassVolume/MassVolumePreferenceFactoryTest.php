<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery\Preference\MassVolume;

use Beeriously\Brewer\Infrastructure\Registration\Form\MassVolume\MassVolumePreferenceFactory;
use Beeriously\Brewer\Infrastructure\Registration\Form\MassVolume\MetricSystemPreference;
use Beeriously\Brewer\Infrastructure\Registration\Form\MassVolume\UnitedStatesCustomarySystemPreference;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class MassVolumePreferenceFactoryTest extends TestCase
{
    public function testCreate()
    {
        $this->assertInstanceOf(MassVolumePreferenceFactory::class, MassVolumePreferenceFactory::create());
    }

    public function testInvalidCode()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('beeriously.user.preferences.invalid_mass_volume');
        MassVolumePreferenceFactory::create()->fromCode('xxx');
    }

    public function testFromCode()
    {
        $factory = MassVolumePreferenceFactory::create();
        $this->assertInstanceOf(UnitedStatesCustomarySystemPreference::class, $factory->fromCode('us'));
        $this->assertInstanceOf(MetricSystemPreference::class, $factory->fromCode('si'));
    }
}
