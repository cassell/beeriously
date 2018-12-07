<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery\Preference\Temperature;

use Beeriously\Brewery\Preference\Temperature\FahrenheitPreference;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class FahrenheitPreferenceTest extends TestCase
{
    public function testGetCode()
    {
        $this->assertEquals('f', (new FahrenheitPreference())->getCode());
    }

    public function testGetTranslation()
    {
        $this->assertEquals('beeriously.measurements.temperature.systems.f.description', (new FahrenheitPreference())->getTranslationDescriptionIdentifier());
    }
}
