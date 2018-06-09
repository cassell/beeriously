<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery\Preference\Temperature;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class CelsiusPreferenceTest extends TestCase
{
    public function testGetCode()
    {
        $this->assertSame('c', (new \Beeriously\Brewery\Application\Preference\Temperature\CelsiusPreference())->getCode());
    }

    public function testGetTranslation()
    {
        $this->assertSame('beeriously.measurements.temperature.systems.c.description', (new \Beeriously\Brewery\Application\Preference\Temperature\CelsiusPreference())->getTranslationDescriptionIdentifier());
    }
}
