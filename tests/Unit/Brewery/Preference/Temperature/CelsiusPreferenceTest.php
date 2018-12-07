<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery\Preference\Temperature;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class CelsiusPreferenceTest extends TestCase
{
    public function testGetCode()
    {
        $this->assertEquals('c', (new \Beeriously\Brewery\Preference\Temperature\CelsiusPreference())->getCode());
    }

    public function testGetTranslation()
    {
        $this->assertEquals('beeriously.measurements.temperature.systems.c.description', (new \Beeriously\Brewery\Preference\Temperature\CelsiusPreference())->getTranslationDescriptionIdentifier());
    }
}
