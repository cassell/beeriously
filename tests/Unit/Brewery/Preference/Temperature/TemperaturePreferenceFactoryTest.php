<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery\Preference\Temperature;

use Beeriously\Brewery\Application\Preference\Temperature\CelsiusPreference;
use Beeriously\Brewery\Application\Preference\Temperature\FahrenheitPreference;
use Beeriously\Brewery\Application\Preference\Temperature\TemperaturePreferenceFactory;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class TemperaturePreferenceFactoryTest extends TestCase
{
    public function testCreate()
    {
        $this->assertInstanceOf(TemperaturePreferenceFactory::class, TemperaturePreferenceFactory::create());
    }

    public function testInvalidCode()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('beeriously.user.preferences.invalid_temperature');
        TemperaturePreferenceFactory::create()->fromCode('xxx');
    }

    public function testFromCode()
    {
        $factory = TemperaturePreferenceFactory::create();
        $this->assertInstanceOf(CelsiusPreference::class, $factory->fromCode('c'));
        $this->assertInstanceOf(FahrenheitPreference::class, $factory->fromCode('f'));
    }
}
